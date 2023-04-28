<?php
/**
 * Created by PhpStorm.
 * User: 联想
 * Date: 2023/1/9
 * Time: 16:23
 */
namespace app\services;
use app\model\User;
use app\model\UserExtract;
use app\model\UserIntegral;
use think\facade\Db;
use think\facade\Log;
class MemberService
{
    /**
     * 新用户注册
     * @param string $openid
     * @param int $invite_code
     * @param array $request
     * @return mixed
     */
    public function register($openid,$invite_code,$request)
    {
        //推荐人
        $invite=User::withSearch(['invite_code'], [
            'invite_code'   =>	$invite_code
        ])
            ->field('id,invite_uid')
            ->find();
        if(!$invite) return false;
        //生成推荐码
        $new_code=$this->mycode();
        $user = new User;
        $user->invite_uid     = $invite['id'];
        $user->invite_path     = $invite['invite_uid'].'-'.$invite['id'];
        $user->invite_code     = $new_code;
        $user->openid     = $openid;
        $user->save($request);
        return true;
    }
    public function mycode()
    {
        $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $rand = $code[rand(0,25)]
            .strtoupper(dechex(date('m')))
            .date('d').substr(time(),-5)
            .substr(microtime(),2,6)
            .sprintf('%02d',rand(0,99));
        for(
            $a = md5( $rand, true ),
            $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
            $d = '',
            $f = 0;
            $f < 6;
            $g = ord( $a[ $f ] ),
            $d .= $s[ ( $g ^ ord( $a[ $f + 5 ] ) ) - $g & 0x1F ],
            $f++
        );
        return $d;
    }
    /**
     * 新用户检查
     * @param int $userid
     * @return bool
     */
    public function newMember($userid)
    {
        $spend=User::where('id',$userid)->value('spend_money');
        if($spend > 0){
            return false;
        }
        return true;
    }
    /**
     * 升级VIP检查
     * @param int $userid
     * @return bool
     */
    public function memberCheck($userid)
    {
        $spend=User::where('id',$userid)->value('spend_money');
        //是否满足最低消费
        $min=config('shop.min_spend');
        if($spend >= $min){
            return true;
        }
        return false;
    }
    /**
     * 当月消费检查
     * @param int $userid
     * @return bool
     */
    public function billCheck($userid)
    {
        $package=User::where('id',$userid)->value('package');
        $bill='';
        if($bill >= $package){
            return true;
        }
        return false;
    }
    /**
     * 积分明细
     * @param int $userid
     * @param int $num
     * @return array
     */
    public function integralList($where,$page){
        $data=UserIntegral::where($where)
            ->page($page,10)
            ->select();
        return $data;
    }
    /**
     * 提现明细
     * @param int $userid
     * @param int $num
     * @return array
     */
    public function extractList($where,$page){
        $data=UserExtract::where($where)
            ->page($page,10)
            ->select();
        return $data;
    }
    /**
     * 消费积分
     * @param int $id
     * @param float $money
     * @return bool
     */
    public function spIntegral($id,$money){
        $integral=$money * (config('shop.spend_integral')/100);
        //增加用户表
        User::where('id',$id)
            ->inc('spend_integral' , $integral)
            ->update();
        //写入明细表
    }
    /**
     * 分销积分
     * @param array $ids 上两级推荐人id
     * @param float $money
     * @return bool
     */
    public function inIntegral($ids,$money){
        $integral=$money * (config('shop.invite_integral')/100);
        User::whereIn('id',$ids)
            ->inc('invite_integral' , $integral)
            ->update();
        //写入明细表
    }
    /**
     * 积分写入事务
     * @param int $id 用户id
     * @param array $pids 上两级推荐id
     * @param float $money 消费金额
     * @return bool
     */
    public function billWrite($id,$pids,$money){
        $spIntegral=$money * (config('shop.spend_integral')/100);
        $inIntegral=$money * (config('shop.invite_integral')/100);
        $time=date('Y-m-d H:i:s',time());
        // 启动事务
        Db::startTrans();
        try {
            //满足条件增加积分
            Db::name('user')->where('id',$id)
                ->inc('spend_integral' , $spIntegral)
                ->update();
            Log::write('消费积分增加成功','info');
            Db::name('user')->whereIn('id',$pids)
                ->inc('invite_integral' , $inIntegral)
                ->update();
            Log::write('分销积分增加成功','info');
            //写入积分明细表
            $data = [
                ['user_id' => $id, 'title' => '用户消费','money'=>$money,'integral'=>$spIntegral,'type'=>1,'time'=>$time],
                ['user_id' => $pids[0], 'title' => '分销收益','money'=>$money,'integral'=>$spIntegral,'type'=>1,'time'=>$time],
                ['user_id' => $pids[1], 'title' => '分销收益','money'=>$money,'integral'=>$spIntegral,'type'=>1,'time'=>$time]
            ];
            Db::name('user_integral')->insertAll($data);
            Log::write('积分明细写入成功','info');
            //写入账单明细
            Db::name('user_bill')->insert(
                ['user_id' => $id, 'title' => '用户消费','money'=>$money,'type'=>1,'add_time'=>$time]
            );
            Log::write('账单明细写入成功','info');
            // 提交事务
            Db::commit();
            Log::write('事务提交成功','info');
        } catch (\Exception $e) {
            // 回滚事务
            Log::write('事务提交回滚','info');
            Db::rollback();
            return false;
        }
        return true;
    }

}