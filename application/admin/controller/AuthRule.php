<?php

namespace app\admin\controller;

use Generate\Traits\Admin\Common;
use Generate\Traits\Admin\Curd;
use Generate\Traits\Admin\CurdInterface;
use think\exception\DbException;

class AuthRule extends Signin implements curdInterface
{
    /*
     * 特别说明
     * Common中的文件不能直接修改！！！！
     * 如果需要进行业务追加操作，请复制Common中的对应的钩子方法到此控制器中后在进行操作
     * Happy Coding
     **/
    use Curd, Common;

    /**
     * @throws DbException
     */
    public function getAll()
    {
        $rules = \app\common\model\AuthRule::all();
        $convertRule = convert_tree($rules, 0, true, true, false);
        $this->returnSuccess($convertRule);
    }
}
