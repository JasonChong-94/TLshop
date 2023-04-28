<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/13
 * Time: 17:05
 */
namespace app\api\validate;

use think\Validate;

class UserAddress extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule =   [
        'name'       => 'require',
        'phone'      => 'require',
        'province'   => 'require',
        'city'       => 'require',
        'district'   => 'require',
        'addr'       => 'require',
//        'num'   => 'number|between:1,10',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message  =   [
//        'product.require' => '名称必须',
//        'product_id.require'     => 'id必须',
//        'product_attr.require'   => '规格必须',
    ];
}