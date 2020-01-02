<?php

namespace app\common\model;

use Generate\Traits\Model\Cache;
use think\Model;

class User extends Model
{
    use Cache; //处理缓存，请勿修改或删除。
    protected $hidden = ['password'];

    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }
}
