<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\app\library\routerFun;

/**
 * 路由规则
 * '路径' => ['请求方式（get/post等）','方法或控制器']
 */
$router = [
    'aa' => ['get', function () {
        echo 123;
    }],
    'test/[:id]' => ['get', 'Test/index'],
];

/**
 * 要显示API的版本
 */
$apiVersion = ['v1'];

/**
 * 路由生成，勿动
 */
$routerFun = new routerFun($apiVersion, $router);
$routerFun->generate();
