<?php

namespace app\common\model;

use Generate\Traits\Model\Cache;
use think\Model;

class Admin extends Model
{
    use Cache;
    protected $autoWriteTimestamp = true;
    protected $hidden = [
        'password',
    ];

    public function setPasswordAttr($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    public function authgroup()
    {
        return $this->belongsToMany(AuthGroup::class, 'auth_group_access', 'group_id', 'uid');
    }
}
