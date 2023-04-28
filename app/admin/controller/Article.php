<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/3/17
 * Time: 15:23
 */
namespace app\admin\controller;

use \app\model\Article as ArticleModel;
use app\BaseController;

class Article extends BaseController
{
    public function list()
    {
        $list=ArticleModel::withSearch(['status'], [
            'status'	    =>	1,
        ])
            ->field('id,path,image,type,title')
            ->select();
        return $this->success($list);
    }
    public function save(){
        $id=$this->request->param('id');
        if($id){
            $model=ArticleModel::find($id);
        }else{
            $model = new ArticleModel;
        }
        $model->save($this->request->all());
        return $this->tips(2000);
    }

}