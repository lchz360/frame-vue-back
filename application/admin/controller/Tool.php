<?php

namespace app\admin\controller;

use Generate\Traits\JsonReturn;
use think\Config;
use think\Controller;
use think\Request;
use think\response\Json;

class Tool extends Controller
{
    use JsonReturn;

    /**
     * 上传图片
     * @return Json|void
     */
    public function uploadImage()
    {
        $config = Config::get('LOCAL');
        $file = request()->file('file');
        if ($file) {
            $info = $file->move($config['rootPath']);
            if ($info) {
                $realPath = $config['relaPath'] . $info->getSaveName();
                $realPath = str_replace('\\', '/', $realPath);
                $this->returnSuccess($realPath);
            } else {
                // 上传失败获取错误信息
                $this->returnFail($file->getError());
            }
        }
        $this->returnFail();
    }

    /**
     * @param Request $request
     */
    public function editorUpload(Request $request)
    {
        $files = $request->file();
        $config = Config::get('LOCAL');
        $data = [];
        foreach ($files as $file) {
            if ($file) {
                $info = $file->move($config['rootPath']);
                if ($info) {
                    $realPath = $config['relaPath'] . $info->getSaveName();
                    $realPath = str_replace('\\', '/', $realPath);
                    $data[] = $realPath;
                } else {
                    // 上传失败获取错误信息
                    $this->returnFail($file->getError());
                }
            }
        }
        $this->returnSuccess($data);
    }
}
