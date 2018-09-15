<?php

class IndexController extends \Base\ApplicationController
{
    private $_weixinToken ='chendongqin4917';

    public function indexAction()
    {
        $request = $this->request;
        $timeStamp = $request->param('timestamp');
        $nonce = $request->param('nonce');
        $token = $this->_weixinToken;
        $signature = $request->param('signature');
        $echostr = $request->param('echostr');
        $array = array($timeStamp,$nonce,$token);
        sort($array);
        $tmpstr = implode('',$array);
        $tmpstr = sha1($tmpstr);
        if($tmpstr == $signature and $echostr){
           return true;
        }
        $str = $this->main();
        \Ku\Log\Adapter::getInstance()->Applog(array($str, __CLASS__, __FUNCTION__, __LINE__));
        echo $str;
        exit();
    }

    public function main(){
        $postArr = file_get_contents('php://input');
        $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
        \Ku\Log\Adapter::getInstance()->Applog(array($postArr, __CLASS__, __FUNCTION__, __LINE__));
        $type = strtolower($postObj->MsgType);
        switch ($type){
            case 'event':
                return true;
                break;
            case 'text':
                return true;
                break;
            default:
                return 'NO TRUE!';
                break;
        }

    }



}
