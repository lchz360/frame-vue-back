<?php

namespace app\app\controller;

use think\Request;

class Tool extends SignIn
{
    /**
     * 上传图片
     * @param Request $request
     */
    public function uploadImage(Request $request)
    {
        // 获取表单上传文件
        $files = $request->file('image');
        $arr = [];
        foreach ($files as $file) {
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $arr[] = '/uploads/' . $info->getSaveName();
            } else {
                // 上传失败获取错误信息
                echo $file->getError();
            }
        }
        $this->returnSuccess($arr);
    }
}
