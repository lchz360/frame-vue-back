<?php

namespace app\app\validate;

use think\Validate;

class Auth extends Validate
{
    protected $rule = [
        'password'     => 'require',
        'old_password' => 'require',
        'username'     => 'require',
        'code'         => 'require',
    ];

    protected $message = [
        'password.require'     => '密码不能为空',
        'old_password.require' => '旧密码不能为空',
        'username.require'     => '用户名不能为空',
        'code.require'         => '验证码不能为空',
    ];

    protected $scene = [
        'edit'          => ['password'],
        'login'         => ['username', 'password'],
        'register'      => ['username', 'password'],
        'resetPassword' => ['username', 'code', 'password', 'old_password'],
    ];
}
