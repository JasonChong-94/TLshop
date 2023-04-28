<?php
declare (strict_types = 1);

namespace app\api\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule =   [
        'phone'   => 'require|length:11',
        'pwd'   => 'require',
        'invite_code'   => 'require',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message  =   [
        'phone.require' => '2010',
        'pwd.require'     => '2011',
        'phone.length'   => '2012',
        'invite_code.require'   => '2007',
    ];
}
