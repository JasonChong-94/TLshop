<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/17
 * Time: 14:34
 */
namespace app\admin\validate;

use think\Validate;

class CategoryValidate extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule =   [
        'cate_name'   => 'require',
        'image'   => 'require',
        'pid'   => 'require|number',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message  =   [
        'cate_name.require' => '4004',
        'image.require'     => '4005',
        'pid.require'     => '4006',
    ];
    public function sceneEdit()
    {
        return $this->only(['id','cate_name','pic'])
            ->append('id', 'require')
            ->remove('image', 'require')
            ->remove('pid', 'require');
    }
}