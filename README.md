# 【QFrame】——桥通天下基础开发框架

> 代码生成工具主要用于生成后台开发中简单的增删改查代码，复杂的逻辑还需自己实现，不过你无须担心，我们通过简单的封装简化了开发流程，即便你是新手，也可以写出出色的代码

## 开始使用

开发环境中执行以下命令，代码生成等功能请查看对应依赖的文档
```shell
$ composer install
```

生产环境中执行
```shell
$ composer install --no-dev
```

**请勿直接将开发环境代码上传到生产环境，有大量多余依赖。**

## 框架说明

框架核心功能为代码生成；主要分为两个大的模块，即前台，后台；目前数据库的操作均为ThinkPHP 5.0中的模型方式。

## 关于性能

为了优化查询性能，默认全部的数据库查询走缓存方式，当然，你也可以在控制器中自己选择是否开启；对此也解决了在执行数据库的增，改，删操作的时候，缓存也会即时刷新，前提是你必须使用model的方式。

## 关于跨域

框架在`application/app`目录下添加了`tags.php`和`behavior/CORS.php`用于解决跨域问题，相应的，只在前台模块有效。
如果在后台模块也需要解决跨域，复制上述文件到`admin`目录并更改命名空间即可。

在`CORS.php`中已经添加了开发过程中常用的域名，不包含在内的域名，继续添加即可。
```php
$allow_host = [
    'http://127.0.0.1:8080',
    'http://localhost:8080',
];
```

## 代码格式化

项目使用`PHP-CS-Fixer`进行代码格式化，并通过`brainmaestro/composer-git-hooks`配置了git钩子实现自动化（commit时执行）。  
项目根目录中已预置`.php_cs`文件，如需更改请自行查看文档。

## 拓展库
- [发送短信拓展](https://github.com/developer-hxc/qt-sms)
- [代码生成](https://github.com/developer-hxc/curd)
- [支付扩展](https://github.com/developer-hxc/qt-pay)

## 相关文档

- [PHP-CS-Fixer](https://github.com/FriendsOfPHP/PHP-CS-Fixer)