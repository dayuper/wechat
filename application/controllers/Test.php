<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-17
 * Time: 下午7:32
 */
class TestController extends \Base\ApplicationController{

    public  function indexAction(){
        $url = 'https://www.yzx.xjlcdx.com/index/api/sms';
        $account = 'b00783';
        $serct = 'b127d1f1';
        $pwd = substr(md5($serct),-32);
        $mobile = '18950164461';
        $sign = '信嘉联创';
        $content = '你好,xyn';
        $param = array('account'=>$account,'password'=>$pwd,'mobile'=>$mobile,'content'=>$content,'sign'=>$sign);
        $http = new \Ku\Http();
        $http->setUrl($url);
        $http->setParam($param,true);
        $res = $http->send();
        var_dump($res);
    }


    public function iAction(){
        $mapper = \M\Mapper\User::getInstance();
        $sql = 'select * from user ';
        $data = $mapper->query($sql)->toArray();
        var_dump($data);
    }
}
