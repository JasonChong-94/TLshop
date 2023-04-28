<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/3/8
 * Time: 16:47
 */

namespace app\admin\controller;

use app\model\Config;
use app\services\FileService;
use app\BaseController;
class SysConfig extends BaseController
{

    public function list()
    {
        $list=Config::select();
        return $this->success($list);
    }
    public function save(){
        $id=$this->request->param('id');
        if($id){
            $model=Config::find($id);
        }else{
            $model = new Config;
        }
        $model->save($this->request->all());
        return $this->tips(2000);
    }
    public function upload(){
        $file = $this->request->file('file');
        if(!$file){
            return $this->fail(4003);
        }
        /** @var FileService $result */
        $result=app()->make(FileService::class);
        $path=$result->image($file,'images');
        if(!$path) return $this->fail(4002);
        return json(['code'=>2000,'path'=>$path]);
    }
    public function wangEditFile(){
        $file = $this->request->file('file');
        if(!$file){
            return $this->fail(4003);
        }
        /** @var FileService $result */
        $result=app()->make(FileService::class);
        $path=$result->image($file,'wangEdit');
        if(!$path) return json(["errno"=>1,"message"=>"失败"]);
        return json(["errno"=>0,"data"=>["url"=>$path]]);

    }
    //批量上传
    public function uploads(){
        $file = $this->request->file('file');
        if(!$file){
            return $this->fail(4003);
        }
        /** @var FileService $result */
        $result=app()->make(FileService::class);
        $path=$result->images($file,'images');
        if(!$path) return $this->fail(4002);
        return json(['code'=>2000,'path'=>$path]);
    }

}
