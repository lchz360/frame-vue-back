<?php

namespace app\common\model;

use Generate\Traits\Model\Cache;
use think\Model;

class AuthRule extends Model
{
    use Cache; //处理缓存，请勿修改或删除。
    protected $type = [
    ];
}
