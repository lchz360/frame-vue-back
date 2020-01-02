<?php

namespace app\app\controller;

use Generate\Traits\App\Common;
use think\Cache;
use think\Controller;
use think\exception\HttpResponseException;
use think\Request;
use think\Session;

class SignIn extends Controller
{
    use Common;

    public function _initialize()
    {
        Session::prefix('app');
        $this->check();
    }

    /**
     * 是否登录
     */
    protected function check()
    {
        $request = Request::instance();
        $token = $request->param('token');
        if ($token) {
            $res = Cache::get($token) ? true : false;
            if (!$res) {
                throw new HttpResponseException($this->notLogin());
            }
        } else {
            $res = Session::get('data', 'auth') ? true : false;
            if (!$res) {
                throw new HttpResponseException($this->notLogin());
            }
        }
        return $res;
    }
}
