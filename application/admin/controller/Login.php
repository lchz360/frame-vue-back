<?php

namespace app\admin\controller;

use Generate\Traits\JsonReturn;
use think\Cache;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\Request;
use think\Session;

/**
 * Class Login
 * 登录控制器
 */
class Login extends Base
{
    use JsonReturn;

    /**
     * 登录操作验证
     * @param Request $request
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function login(Request $request)
    {
        if ($request->isPost()) {
            $account = $request->post('username');
            $password = $request->post('password');

            if (!$account || !$password) {
                $this->returnFail('登录参数错误');
            }

            $code = -1;

            // 登录记录
            $log = [];
            $log['ip'] = $request->ip();
            $log['port'] = $request->port();
            $log['browser'] = $request->header('USER_AGENT');
            $log['user'] = $account;
            $log['create_time'] = date('Y-m-d H:i:s');
            $log['status'] = 0;

            // 登录
            $admin = \app\common\model\Admin::where('account', $account)->find();

            if ($admin) {
                if (password_verify($password, $admin['password'])) {
                    if (password_needs_rehash($admin['password'], PASSWORD_DEFAULT)) {
                        $admin['password'] = $password;
                        $admin->save();
                    }
                    $log['status'] = 1;
                    $code = 1;
                    $msg = '登录成功！';
                    Session::set('data', $admin, 'admin');

                    $token = $this->getToken([
                        'id'      => $admin['id'],
                        'account' => $admin['account'],
                    ]);
                    $token_expire = config('token_expire');
                    Cache::set($token, $admin, $token_expire);
                } else {
                    $msg = '密码错误';
                }
            } else {
                $msg = '账号不存在';
            }

            $log['note'] = $msg;
            Db::name('AdminLoginLog')->insert($log);

            if ($code == -1) {
                $this->returnFail($msg);
            }

            $data = $admin->toArray();
            $data['token'] = $token;

            // 登录成功
            $this->returnSuccess($data);
        }
        $this->error('请求方式错误！');
    }

    protected function getToken($params)
    {
        //用户id-用户账号-有效期-登录时间-角色
        $expire = config('token_expire') == 0 ? 0 : time() + config('token_expire');
        return base64_encode($params['id'] . '-' . $params['account'] . '-' . $expire . '-' . time());
    }

    /**
     * 退出登录
     * @param Request $request
     */
    public function logOut(Request $request)
    {
        Session::set('data', null, 'admin');
        if ($request->has('token')) {
            Cache::rm($request->param('token'));
        }
        $this->returnSuccess();
    }
}
