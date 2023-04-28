<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/13
 * Time: 14:25
 */
namespace app\services;
use app\model\Exchange;
use app\model\Product;

class GoodsService
{
    /**
     * 产品列表
     * @param array $search
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function list($search,$where,$field)
    {
        $data=Product::withSearch($search,$where)
            ->field($field)
            ->paginate(10);
        return $data;
    }
    /**
     * 积分兑换列表
     * @param array $search
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function exList($search,$where,$field)
    {
        $data=Exchange::withSearch($search,$where)
            ->field($field)
            ->paginate(10);
        return $data;
    }
    /**
     * 积分产品保存
     * @param array $request
     * @return mixed
     */
    public function exCreate($request){
        $model = new Exchange();
        $model->save($request);
        return $model->id;
    }
    /**
     * 积分产品修改
     * @param array $request
     * @return bool
     */
    public function exUpdate($request){
        $model = Exchange::find($request['id']);
        if(!$model) return false;
        $model->save($request);
        return true;
    }
    /**
     * 产品详细信息
     * @param int $id
     * @return mixed
     */
    public function info($id)
    {
        $data=Product::with(['attr','attr_val','desc'])->find($id);
        return $data;
    }
    /**
     * 产品保存
     * @param array $request
     * @return mixed
     */
    public function create($request){
        $model = new Product();
        $model->save($request);
        //多规格判断
        if($request['spec_type']){
            $model->attr()->saveAll($request['attr']);
            $model->attrVal()->saveAll($request['attr_val']);
        }
        $model->desc()->save($request['desc']);
        return $model->id;
    }
    /**
     * 产品修改
     * @param array $request
     * @return bool
     */
    public function update($request){
        $model = Product::find($request['id']);
        if(!$model) return false;
        $model->desc->description = $request['desc']['description'];
        $model->together(['desc'])->save($request);
        return true;
    }
    /**
     * 产品上下架
     * @param int $id
     * @param int $is_show
     * @return bool
     */
    public function isShow($id,$is_show){
        $model = Product::find($id);
        if(!$model) return false;
        $model->is_show = $is_show;
        $model->save();
        return true;
    }
    //api
    /**
     * 积分兑换列表
     * @param array $search
     * @param array $where
     * @param string $field
     * @return mixed
     */
    public function getExList($where,$field,$page)
    {
        $data=Exchange::where($where)
            ->field($field)
            ->page($page,6)
            ->select();
        return $data;
    }

}