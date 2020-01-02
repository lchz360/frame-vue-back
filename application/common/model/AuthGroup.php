<?php

namespace app\common\model;

use Generate\Traits\Model\Cache;
use think\Model;

class AuthGroup extends Model
{
    use Cache; //处理缓存，请勿修改或删除。
    protected $type = [
    ];

    public function setRulesAttr($value)
    {
        if (is_array($value)) {
            return implode(',', $value);
        }
        return $value;
    }

    public function getRulesAttr($value)
    {
        return explode(',', $value);
    }
}
