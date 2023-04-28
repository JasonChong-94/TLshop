<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/14
 * Time: 16:45
 */
namespace app\services;



use app\model\Cart;
use app\model\Product;

class CartService
{
    /**
     * 购物车数据
     * @param array $cartList
     * @return array
     */
    public function cartList($cartList)
    {
//        $result= array();
        foreach ($cartList as $value){
            if($value['attrInfo']){
                $value['suk']=$value['attrInfo']['suk'];
                $value['stock']=$value['attrInfo']['stock'];
                $value['price']=$value['attrInfo']['price'];
                $value['vip_price']=$value['attrInfo']['vip_price'];
            }else{
                $value['suk']='';
                $value['stock']=$value['productInfo']['stock'];
                $value['price']=$value['productInfo']['price'];
                $value['vip_price']=$value['productInfo']['vip_price'];
            }
            unset($value['attrInfo']);
            unset($value['productInfo']);
        }

        return $cartList;
    }
    /**
     * 处理购物车结算数据
     * @param array $cartList
     * @return array
     */
    public function handleCartList($cartList){
        foreach ($cartList as $value){
            if($value['attrInfo']){
                if($value['num']>$value['attrInfo']['stock']){
                    $result['msg']=$value['attrInfo']['suk'].'库存不足';break;
                }
                $value['suk_id']=$value['attrInfo']['id'];
                $value['suk']=$value['attrInfo']['suk'];
                $value['stock']=$value['attrInfo']['stock'];
                $value['price']=$value['attrInfo']['price'];
                $value['vip_price']=$value['attrInfo']['vip_price'];
            }else{
                if($value['num']>$value['productInfo']['stock']){
                    $result['msg']=$value['product'].'库存不足';break;
                }
                $value['suk_id']='';
                $value['suk']='';
                $value['stock']=$value['productInfo']['stock'];
                $value['price']=$value['productInfo']['price'];
                $value['vip_price']=$value['productInfo']['vip_price'];
            }
            unset($value['attrInfo']);
            unset($value['productInfo']);
        }

        return $cartList;
    }
    /**
     * 购物车结算数据 合并商家
     * @param array $cartList
     * @return array
     */
    public function cartMerList($cartList){
        $result= array();
        foreach ($cartList as $value){
            if($value['attrInfo']){
                if($value['num']>$value['attrInfo']['stock']){
                    $result['msg']=$value['attrInfo']['suk'].'库存不足';break;
                }
                $value['suk_id']=$value['attrInfo']['id'];
                $value['suk']=$value['attrInfo']['suk'];
                $value['stock']=$value['attrInfo']['stock'];
                $value['price']=$value['attrInfo']['price'];
                $value['vip_price']=$value['attrInfo']['vip_price'];
            }else{
                if($value['num']>$value['productInfo']['stock']){
                    $result['msg']=$value['product'].'库存不足';break;
                }
                $value['suk_id']='';
                $value['suk']='';
                $value['stock']=$value['productInfo']['stock'];
                $value['price']=$value['productInfo']['price'];
                $value['vip_price']=$value['productInfo']['vip_price'];
            }
            unset($value['attrInfo']);
            unset($value['productInfo']);
            $result[$value['mer_id']][]=$value;
        }

        return $result;
    }
    /**
     * 为你推荐
     * @param int $userid
     * @return mixed
     */
    public function recommend($userid)
    {
        $cart_id=Cart::where('user_id',$userid)->column('cate_id');
        $arr = array_count_values($cart_id); // array_count_values函数对数组中的所有值进行计数
        arsort($arr); //倒排数组
        $max_key = key($arr);
        $goods=Product::where('category_id',$max_key)->limit(10)->select();
        if(count($goods)==0){
            $goods=Product::limit(10)->select();
        }
        return $goods;
    }
}