<?php

namespace app\admin\controller;

use think\Cache;
use think\Controller;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;
use think\Request;
use think\Session;

/**
 * Class Base
 */
class Base extends Controller
{
    /**
     * 验证是否登录
     * @return bool
     */
    protected function isLogin()
    {
        $request = Request::instance();
        $token = $request->param('token');
        if ($token) {
            $res = Cache::get($token) ? true : false;
            if (!$res) {
                return false;
            }
        } else {
            $res = Session::get('data') ? true : false;

            if (!$res) {
                return false;
            }
        }
        return $res;
    }

    /**
     * 清除所有缓存（数据缓存、模板缓存）
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function clearCacheData()
    {
        // 清除数据缓存
        Cache::clear();
        // 清除模板缓存
        clear_temp_cache();
        // 重新加载缓存
        cacheSettings();

        $this->success('缓存信息已刷新！');
    }
}
