<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/2/18
 * Time: 11:06
 */
namespace app\services;

use app\model\Category;
use think\facade\Request;

class CategoryService
{
    /**
     * 列表
     * @return array
     */
    public function gList($search,$where){
        $data=Category::withSearch($search,$where)
            ->order('sort','desc')
            ->select()
            ->toArray();
        $list=$this->get_tree_children($data);
        return $list;
    }
    /**
     * tree 子菜单
     * @param array $data 数据
     * @param string $childrenname 子数据名
     * @param string $keyName 数据key名
     * @param string $pidName 数据上级key名
     * @return array
     */
    function get_tree_children($data, $childrenname = 'children', $keyName = 'id', $pidName = 'pid')
    {
        $list = array();
        foreach ($data as $value) {
            $list[$value[$keyName]] = $value;
        }
        static $tree = array(); //格式化好的树
        foreach ($list as $item) {
            if (isset($list[$item[$pidName]])) {
                $list[$item[$pidName]][$childrenname][] = &$list[$item[$keyName]];
            } else {
                $tree[] = &$list[$item[$keyName]];
            }
        }
        return $tree;
    }
    public function create($request){
        $model = new Category;
        $model->save($request);
        return $model->id;
    }
    public function update($request){
        if(isset($request['pic'])){
            /** @var FileService $result */
            $result=app()->make(FileService::class);
            $path=$result->image($request['pic'],'goods');
            if(!$path) return false;
        }
        $model = Category::find($request['id']);
        if(isset($path)) $model->image     = $path;
        $model->save($request);
        return true;
    }
}