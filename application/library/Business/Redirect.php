<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-18
 * Time: 下午7:30
 */
namespace Business;

final class Redirect extends BusinessAbstract
{
    use Instance;


    public function authorize($params){
        if(!isset($params['code'])){
            return $this->getMsg(1230,'未捕获code');
        }
        $code = $params['code'];
        $weChat = \Ku\Wechat\Wechat::getInstance();
        $res = $weChat->code2AccessToken($code);
        $res = json_decode($res,true);
        $user = \M\Mapper\User::getInstance()->fetch(array('openId'=>$res['openid']));
        $wechatUser = $weChat->token2User($res['access_token']);
        $wechatUser = json_decode($wechatUser,true);
        $user->setStatus(2);
        $user->setUser_name($wechatUser['nickname']);
        $res = \M\Mapper\User::getInstance()->update($user);
        return $res;
    }

}