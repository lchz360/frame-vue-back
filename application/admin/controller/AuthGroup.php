<?php

namespace app\admin\controller;

use Generate\Traits\Admin\Common;
use Generate\Traits\Admin\Curd;
use Generate\Traits\Admin\CurdInterface;
use think\exception\DbException;

class AuthGroup extends Signin implements curdInterface
{
    /*
     * 特别说明
     * Common中的文件不能直接修改！！！！
     * 如果需要进行业务追加操作，请复制Common中的对应的钩子方法到此控制器中后在进行操作
     * Happy Coding
     **/
    use Curd, Common;

    protected $cache = true; //是否使用缓存
    protected $modelName = 'AuthGroup';  //模型名
    protected $indexField = ['id', 'title'];  //查，字段名
    protected $addField = ['title', 'rules'];    //增，字段名
    protected $editField = ['title', 'rules'];   //改，字段名
    /**
     * 条件查询，字段名,例如：无关联查询['name','age']，关联查询['name','age',['productId' => 'product.name']],解释：参数名为productId,关联表字段p.name
     * 默认的类型为输入框，如果有下拉框，时间选择等需求可以这样定义['name',['type' => ['type','select']]];目前有select,time_start,time_end三种可被定义
     * 通过模型定义的关联查询，可以这样定义['name',['memberId'=>['member.nickname','relation']]],只能有一个关联方法被定义为relation，且字段前的表别名必须为关联的方法名
     * @var array
     */
    protected $searchField = ['title'];
    protected $orderField = '';  //排序字段
    protected $pageLimit = 10;               //分页数

    //增，数据检测规则
    protected $add_rule = [
        //'nickName|昵称'  => 'require|max:25'
        'title|角色名称' => 'require',
        'rules|权限'   => 'require',
    ];
    //改，数据检测规则
    protected $edit_rule = [
        //'nickName|昵称'  => 'require|max:25'
        'title|角色名称' => 'require',
        'rules|权限'   => 'require',
    ];

    /**
     * @throws DbException
     */
    public function getAll()
    {
        $data = \app\common\model\AuthGroup::all();
        $this->returnSuccess($data);
    }
}
