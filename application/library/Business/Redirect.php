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
        \Ku\Log\Adapter::getInstance()->Applog(array(json_encode($res), __CLASS__, __FUNCTION__, __LINE__));
        return $res;
    }

}