<?php

class IndexController extends \Base\ApplicationController
{
    private $_weixinToken ='chendongqin4917';

    public function indexAction()
    {
        $request = $this->request;
        $timeStamp = $request->param('timestamp');
        $nonce = $request->param('nonce');
        $signature = $request->param('signature');
        $echostr = $request->param('echostr');
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
