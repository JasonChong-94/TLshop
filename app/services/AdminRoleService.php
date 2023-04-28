<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2022/12/14
 * Time: 16:45
 */
namespace app\services;
use app\model\AdminRoles;
use app\model\AdminUsers;
class AdminRoleService
{
    /**
     * 管理员登录
     * @param string $account
     * @param string $pwd
     * @return array|bool
     */
    public function login($account,$pwd)
    {
        $map[] = ['account','=',$account];
        $map[] = ['password','=',md5($pwd)];
        $user=AdminUsers::where($map)->find();
        if(!$user) return false;
        $role_id=AdminUsers::roleId($user->id);
        $menu = $role_id?$this->getMenu($role_id):'';
        //生成token,保存用户登录状态
        $token = (new AdminTokenService())->generateToken($user->id);
        return ['token'=>$token,'menu'=>$menu];
    }
    /**
     * 管理员列表
     * @param string field
     * @return array
     */
    public function list($field)
    {
        $user=AdminUsers::field($field)->select();
        return $user;
    }
    /**
     * 管理员修改
     * @param integer $id
     * @param array $request
     * @return array|bool
     */
    public function save($id,$request)
    {
        if($id){
            $model=AdminUsers::find($id);
        }else{
            $model = new AdminUsers;
        }
        $model->save($request);
        return $model->id;
    }
    /**
     * 获取后台菜单权限
     * @param array $roles
     * @return array|bool
     */
    public function getMenu($roles){
        $attr=[];
        foreach ($roles as $role){
            $menus=AdminRoles::find($role);
            if(!$menus) return '';
            foreach ($menus->menu->toArray() as $m){
                array_push($attr,$m);
            }
        }
        $items = [];
        foreach ($attr as $v){
            unset($v['pivot']);
            $items[$v['id']] = $v;
        }
        $tree = array(); //格式化好的树
        foreach ($items as $item)
            if (isset($items[$item['parent_id']]))
                $items[$item['parent_id']]['son'][] = &$items[$item['id']];
            else
                $tree[] = &$items[$item['id']];

        return $tree;
    }
}