<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/4/13
 * Time: 9:57
 */
namespace app\admin\validate;

use think\Validate;

class ExchangeValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule =   [
        'product_id'   => 'require',
//        'mer_id'   => 'require',
        'image'   => 'require',
        'images'   => 'require',
        'name'   => 'require',
        'price'   => 'require',
        'stock'   => 'require|number',
        'ex_integral'   => 'require',
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