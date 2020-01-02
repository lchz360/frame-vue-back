<?php

namespace app\app\behavior;

class CORS
{
    public function moduleInit()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            //允许的地址，可继续添加
            $allow_host = [
                'http://127.0.0.1:8080',
                'http://localhost:8080',
                'chrome-extension://cmnlfmgbjmaciiopcgodlhpiklaghbok',
                'chrome-extension://aejoelaoggembcahagimdiliamlcdmfm',
                'chrome-extension://aicmkgpgakddgnaphhhpliifpcfhicfo',
            ];
            $http_origin = $_SERVER['HTTP_ORIGIN'];
            if (!in_array($http_origin, $allow_host)) {
                exit();
            }
            header("Access-Control-Allow-Origin: {$http_origin}");
            header('Access-Control-Allow-Headers: token, Origin, X-Requested-With, Content-Type, Accept, Authorization');
            header('Access-Control-Allow-Methods:POST, GET, PUT, DELETE, OPTIONS');
            header('Access-Control-Max-Age: 600');
            if (request()->isOptions()) {
                exit();
            }
        }
    }
}
