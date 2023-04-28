<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/1
 * Time: 17:23
 */

namespace app\api\controller\category;

use app\BaseController;
use app\model\Category;
use app\model\Product;

class Index extends BaseController
{

    /*public function index()
    {
        $data=Category::select()->order('sort','desc')->toArray();
        $items = [];
        foreach ($data as $v){
            $items[$v['id']] = $v;
        }
        $tree = array(); //格式化好的树
        foreach ($items as $item)
            if (isset($items[$item['pid']]))
                $items[$item['pid']]['son'][] = &$items[$item['id']];
            else
                $tree[] = &$items[$item['id']];
        return $this->success($tree);

    }*/
    public function index()
    {
        $data=Category::withSearch(['pid'], [
            'pid'			=>	0,
            'sort'			=>	['sort'=>'desc'],
        ])
            ->field('id,cate_name,image')
            ->select();
        return $this->success($data);

    }
    public function getGoodsByCate(){

        $type=$this->request->param('type');
        $page=$this->request->param('page',1);
        $cate_id=$this->request->param('cate_id');
        if(!$cate_id){
            return $this->fail(2002);
        }
        switch($type){
            case 1:
                $sort=['price'=>'desc'];
                break;
            case 2:
                $sort=['price'=>'asc'];
                break;
            case 3:
                $sort=['sales'=>'desc'];
                break;
            case 4:
                $sort=['sales'=>'asc'];
                break;
            default:
                $sort=['id'=>'desc'];
        }
        $data=Product::withSearch(['is_show','category_id'], [
            'is_show'	    =>	1,
            'category_id'	    =>	$cate_id,
            'sort'			=>	$sort,
        ])
            ->field('id,name,keyword,price,vip_price,image,sales')
            ->page($page,6)
            ->select();
        if($data->isEmpty()){
            return $this->fail(3001);
        }
        return $this->success($data);
    }
}
