<?php

namespace app\admin\controller;

use Generate\Traits\JsonReturn;
use PDOStatement;
use think\Auth;
use think\Cache;
use think\Collection;
use think\Config;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Loader;
use think\Request;
use think\Session;

class Signin extends Base
{
    use JsonReturn;
    /**
     * 无需权限认证部分
     * @var array
     */
    protected $unblock = [
        'index/index',
        'index/main',
        'signin/getauthlist',
    ];

    public function _initialize()
    {
        parent::_initialize();
        // 是否登录
        if ($this->isLogin() === false) {
            $this->returnFail('未登录', -1);
        }
//        // 是否拥有访问权限(超级管理员除外)
        if (!in_array($this->getAuthId(), Config::get('supermanager'))) {
            if (!$this->authCheck()) {
                $this->error('无权限访问！');
            }
        }
    }

    /**
     * 获取当前登录用户的id
     * @return mixed
     */
    public function getAuthId()
    {
        static $id = null;
        if (is_null($id)) {
            $id = $this->getAuth()['id'];
        }
        return $id;
    }

    /**
     * 获取当前登录用的数据
     * @return mixed
     */
    public function getAuth()
    {
        $token = Request::instance()->param('token');
        if ($token) {//token登录
            $res = Cache::get($token);
        } else {//web登录
            $res = Session::get('data');
        }
        return $res;
    }

    /**
     * 权限检测
     * @return bool
     */
    protected function authCheck()
    {
        $controller = request()->controller();
        $action = request()->action();
        $auth = new Auth();
        // 首页 登出 无需权限检测
        $url = strtolower(Loader::parseName($controller) . '/' . $action);
        if (!in_array($url, $this->unblock)) {
            if (!$auth->check($url, $this->getAuthId())) {
                return false;
            }
        }
        return true;
    }

    public function getAuthList()
    {
        $auth = new \app\common\library\Auth();
        $authList = $auth->getAuthList($this->getAuthId());
        $data = [
            'auth'  => array_merge($authList),
            'super' => false,
        ];
        if (in_array($this->getAuthId(), Config::get('supermanager'))) {
            $data['super'] = true;
        }
        $this->returnSuccess($data);
    }

    /**
     * 获取菜单
     * @return array|false|PDOStatement|string|Collection
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     */
    protected function getMenu()
    {
        // 所有菜单
        $menu = Db::name('authrule')->field('id,name,title,status,pid,faicon,sort')->order('sort ASC')->select();
        // 拥有权限菜单
        $auth = new Authority();
        $uid = Session::get('uid', 'admin');
        $ruleList = $auth->getAuthList($uid, 1);

        if (in_array($uid, Config::get('supermanager'))) {
            // 超级管理员
            return $menu;
        }
        // 后台用户
        return $ruleList;
    }
}
