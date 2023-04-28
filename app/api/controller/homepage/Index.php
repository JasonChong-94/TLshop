<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/11/30
 * Time: 11:47
 */

namespace app\api\controller\homepage;

use app\BaseController;
use app\model\Article;
use app\model\Category;
use app\model\Product;

class Index extends BaseController
{

    //获取首页配置
    public function index()
    {
        $adv=Article::withSearch(['status','block'], [
            'status'	    =>	1,
            'block'	    =>	1,
        ])
            ->field('id,describe,path,image,type,title')
            ->select();
        foreach ($adv as $v){
            switch($v['type']){
                case 0:
                    $data['banner'][]=$v;
                    break;
                case 1:
                    $data['nav'][]=$v;
                    break;
                default:
            }
        }
        return $this->success($data);

    }
    public function goods()
    {
        $type=$this->request->param('type',0);
        $page=$this->request->param('page',1);
        switch($type){
            case 1:
                //新品
                $search=['is_show','is_new'];
                $where=[
                    'is_show'	    =>	1,
                    'is_new'	    =>	1,
                ];
                break;
            case 2:
                //热卖
                $search=['is_show','is_hot'];
                $where=[
                    'is_show'	    =>	1,
                    'is_hot'	    =>	1,
                ];
                break;
            case 3:
                //推荐
                $search=['is_show','is_best'];
                $where=[
                    'is_show'	    =>	1,
                    'is_best'	    =>	1,
                ];
                break;
            default:
                $search=['is_show'];
                $where=[
                    'is_show'	    =>	1,
                ];
        }
        $data=Product::withSearch($search, $where)
            ->field('id,name,price,vip_price,image')
            ->page($page,6)
            ->select();
        if($data->isEmpty()){
            return $this->fail(3001);
        }
        return $this->success($data);
    }
    public function search(){
        $data=Product::withSearch(['is_show','name'],[
            'is_show'	    =>	1,
            'name'	    =>	$this->request->param('name'),
        ])
            ->field('id,name,price,vip_price,image')
            ->select();
        return $this->success($data);
    }
}
