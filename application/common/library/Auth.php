<?php

namespace app\common\library;

class Auth extends \think\Auth
{
    public function getAuthList($uid, $type = 1)
    {
        return parent::getAuthList($uid, $type);
    }
}
