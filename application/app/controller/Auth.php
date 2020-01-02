<?php

namespace app\app\controller;

use app\common\model\User as AuthModel;
use Generate\Traits\App\Common;
use think\Cache;
use think\Config;
use think\Controller;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\exception\HttpResponseException;
use think\Request;
use think\Session;

class Auth extends Controller
{
    use Common;

    protected $username = 'mobile'; //登录用户名，可选定user中的任意字段

    /**
     * 登录方法
     * @param Request $request
     * @throws Exception
     */
    public function login(Request $request)
    {
        $params = $request->param();
        $params_status = $this->validate($params, 'Auth.login');
        if (true !== $params_status) {
            // 验证失败 输出错误信息
            $this->returnFail($params_status);
        }
        $loginRes = $this->validateLogin($params);
        $data = [];
        if ($loginRes) {//登录成功
            $data = $loginRes->toArray();
            $token = $this->generateToken($data);
            $this->setAuth($data, $token);
            $data['token'] = $token;
            $config = Config::get('im');
        }
        $this->returnRes($loginRes, '登录失败:密码不正确', $data);
    }

    /**
     * 登录验证
     * @param $data
     * @return AuthModel|bool|null
     * @throws DbException
     */
    protected function validateLogin($data)
    {
        $username = $data['username'];
        $password = $data['password'];
        $auth = AuthModel::get([$this->username => $username, 'status' => 1]);
        if ($auth) {
            return password_verify($password, $auth->password) ? $auth : false;
        }
        return false;
    }

    /**
     * 获取token
     * @param $params
     * @return string
     */
    protected function generateToken($params)
    {
        $expire = config('token_expire') == 0 ? 0 : time() + config('token_expire');
        //用户id-用户名-有效期-登录时间
        $token = base64_encode($params['id'] . '-' . $params['name'] . '-' . $expire . '-' . time());
        return $token;
    }

    /**
     * 设置登录
     * @param $data
     * @param $token
     */
    protected function setAuth($data, $token)
    {
        $token_expire = config('token_expire');
        Cache::set($token, $data, $token_expire);
        Session::set('data', $data, 'auth');
    }

    /**
     * 注册
     * @param Request $request
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    public function register(Request $request)
    {
        $params = $request->param();
        $params_status = $this->validate($params, 'Auth.register');
        if (true !== $params_status) {
            // 验证失败 输出错误信息
            $this->returnFail($params_status);
        }
        $status = AuthModel::where([$this->username => $params['username']])->find();
        if ($status) {
            $this->returnFail('会员已存在');
        }
        $params[$this->username] = $params['username'];
        $auth = new AuthModel();
        $auth->data($params, true);
        $res = $auth->allowField(true)->save();
        if ($res) {
            //自增id
            $id = $auth->id;
            $this->returnSuccess('账号创建成功');
        } else {
            $this->returnFail('账号创建失败');
        }
    }

    /**
     * 修改密码
     * @param Request $request
     * @throws DbException
     */
    public function resetPassword(Request $request)
    {
        $params = $request->param();
        $params_status = $this->validate($params, 'Auth.resetPassword');
        if (true !== $params_status) {
            // 验证失败 输出错误信息
            $this->returnFail($params_status);
        }
        $user = AuthModel::get(['mobile' => $params['username'], 'status' => 1]);
        if (empty($user)) {
            $this->returnFail('用户不存在');
        }
        Db::startTrans();   //开启事务
        try {
            /*******检验验证码******/
            $sms_config = Config::get('sms'); //或其他方式传入配置，配置格式见上文
            $qt_sms = new QTSms($sms_config);
            $reset = $qt_sms->check($params['username'], $params['code'], 'reset');
            if ($reset['code'] == 0) {
                $this->returnFail($reset['message']);
            }
            /******校验密码********/
            if ($params['old_password'] != $params['password']) {
                $this->returnFail('两次密码输入不一致');
            }
            $save_status = $user->validate('Auth.edit')->allowField(true)->save([
                'password' => $params['password'],
            ]);
            if (false === $save_status) {
                $this->returnFail($user->getError());
            }
        } catch (HttpResponseException $e) {
            Db::rollback();
            throw $e;
        } catch (\Exception $e) {
            Db::rollback();  //事务回滚
            $this->returnFail($e->getMessage());
        }
        Db::commit(); //事务完成
        $this->returnSuccess();
    }
}
