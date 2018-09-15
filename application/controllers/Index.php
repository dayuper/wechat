<?php

class IndexController extends \Base\ApplicationController
{

    public function indexAction()
    {
        $request = $this->getRequest();
        $timeStamp = $request->get('timestamp');
        $nonce = $request->get('nonce');
        $signature = $request->get('signature');
        $echostr = $request->get('echostr');
        $wechat = \Ku\Wechat\Wechat::getInstance();
        $res = $wechat->checkSignatrue($timeStamp,$nonce,$signature);
        if(!$res){
            echo 'fail';
            exit();
        }
        $content = $wechat->getXmlContent();
        if($content === false){
            echo $echostr;
            exit();
        }
        echo 'success';
        exit();
    }




}
