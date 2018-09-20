<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-20
 * Time: 下午6:46
 */
namespace Business;
class Wechatuser extends \Business\BusinessAbstract{
use \Business\Instance;
    /**添加用户
     * @param $openId
     * @return bool
     */
    public function add($openId){
        $user = new \M\User();
        $user->setOpenId($openId);
        $user->setCreate_time(date('YmdHis'));
        $user->setUpdate_time(date('YmdHis'));
        $res = \M\Mapper\User::getInstance()->insert($user);
        if($res === false){
            return $this->getMsg(1000,'添加用户失败');
        }
        return true;
    }

    /**更改用户绑定状态
     * @param $openId
     * @param $status
     * @return bool
     */
    public function update($openId,$status){
        $mapper = \M\Mapper\User::getInstance();
        $user = $mapper->fetch(array('openId'=>$openId));
        if(!$user instanceof \M\User){
            $this->add($openId);
            $user = $mapper->fetch(array('openId'=>$openId));
        }
        $user->setUpdate_time(date('YmdHis'));
        $user->setStatus($status);
        $res = $mapper->update($user);
        if($res ===false){
            return $this->getMsg(1000,'更改失败');
        }
        return true;
    }

}