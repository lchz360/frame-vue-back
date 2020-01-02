<?php

use think\Cache;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\exception\DbException;

/**
 * 根据小时判断早上 中午 下午 傍晚 晚上
 * @param string $h [1-24]
 * @return string
 */
function get_curr_time_section($h = '')
{
    //如果没有传入参数，则取当前时间的小时
    if (empty($h)) {
        $h = date('H');
    }

    if ($h < 11) {
        $str = '早上好';
    } elseif ($h < 13) {
        $str = '中午好';
    } elseif ($h < 17) {
        $str = '下午好';
    } elseif ($h < 19) {
        $str = '傍晚好';
    } else {
        $str = '晚上好';
    }

    return $str;
}

/**
 * 格式化的当前日期
 *
 * @return false|string
 */
function now_datetime()
{
    return date('Y-m-d H:i:s');
}

/**
 * 清除模版缓存 不删除 temp目录
 */
function clear_temp_cache()
{
    $temp_files = (array) glob(TEMP_PATH . DS . '*.php');
    array_map(function ($v) {
        if (file_exists($v)) {
            @unlink($v);
        }
    }, $temp_files);
    return true;
}

/**
 * 重新加载配置缓存信息
 * @return array
 * @throws DataNotFoundException
 * @throws ModelNotFoundException
 * @throws DbException
 */
function loadCache()
{
    $settings = Db::name('setting')->select();
    $refer = [];
    if ($settings) {
        foreach ($settings as $k => $v) {
            $refer[$v['module']][$v['code']] = $v['val'];
        }
    }
    return $refer;
}

/**
 * 配置缓存
 * 加载系统配置并缓存
 * @return array
 * @throws DataNotFoundException
 * @throws DbException
 * @throws ModelNotFoundException
 */
function cacheSettings()
{
    Cache::set('settings', null);
    $settings = loadCache();
    Cache::set('settings', $settings, 0);
    return $settings;
}

/**
 * 获取配置缓存信息
 * @param string $module
 * @param string $code
 * @return mixed|null
 * @throws DataNotFoundException
 * @throws DbException
 * @throws ModelNotFoundException
 */
function getSettings($module = '', $code = null)
{
    $settings = Cache::get('settings');
    if (empty($settings)) {
        $settings = cacheSettings();
    }

    if (empty($settings)) {
        return null;
    }

    if (is_null($code)) {
        if (array_key_exists($module, $settings)) {
            return $settings[$module];
        }
    } else {
        if (array_key_exists($module, $settings) && array_key_exists($code, $settings[$module])) {
            return $settings[$module][$code];
        }
    }
    return null;
}

/**
 * 手机号格式检测
 * @param $str
 * @return bool
 */
function isPhone($str)
{
    return (preg_match("/^1[3456789]\d{9}$/", $str)) ? true : false;
}
