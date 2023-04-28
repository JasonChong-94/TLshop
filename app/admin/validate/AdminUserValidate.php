<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/27
 * Time: 16:14
 */
namespace app\admin\validate;

use think\Validate;

class AdminUserValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule =   [
        'id'   => 'integer',
        'account'   => 'require',
        'password'   => 'require',
        'name'   => 'max:100',
        'avatar'   => 'max:255',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message  =   [

    ];
}