<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/24
 * Time: 16:48
 */
namespace app\admin\validate;

use think\Validate;

class ProductValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule =   [
        'name'   => 'require',
        'category_id'   => 'require',
        'bar_code'   => 'require',
        'describe'   => 'require|max:255',
        'spec_type'   => 'require|number',
        'image'   => 'require',
        'images'   => 'require',
        'price'   => 'require',
        'cos_price'   => 'require',
        'vip_price'   => 'require',
//        'ex_integral'   => 'require|number',
        'stock'   => 'require|number',
        'unit'   => 'max:50',
        'weight'   => 'max:50',
        'logistics'   => 'max:50',
        'attr'=>'array',
        'attr_val'=>'array',
        'desc'=>'require',
        'is_show'=>'number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message  =   [
//        'name.require' => '4004',
//        'category_id.require'     => '4005',
//        'price.image'     => '4005',
//        'vip_price.require'     => '4006',
    ];
    public function sceneEdit()
    {
        return $this->append('id', 'require|integer');
    }
}