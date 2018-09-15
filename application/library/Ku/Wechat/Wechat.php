<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-15
 * Time: 下午6:07
 */
namespace Ku\Wechat;

class Wechat{
    use Instance;

    private $_api = 'https://api.weixin.qq.com/';
    private $_appId = '';
    private $_AppSecret = '';
    private $_wechatToken = '';

    public function __construct()
    {
        $config = \Yaf\Registry::get('config');
        $conf = $config->get('resources.wechat');
        if (!isset($conf['appid']) || !isset($conf['appsecret'])) {
            throw new \Exception("微信 未配置", 1);
        }
        $this->_appId = $conf['appid'];
        $this->_AppSecret = $conf['appsecret'];
        $this->_wechatToken = $conf['token'];
    }


    public function checkSignatrue($timeStamp,$nonce,$signature){
        $token = $this->_wechatToken;
        $array = array($timeStamp,$nonce,$token);
        sort($array);
        $tmpstr = implode('',$array);
        $tmpstr = sha1($tmpstr);
        if($tmpstr == $signature){
            return true;
        }
        return false;

    }

    public function getAccessToken(){

    }


    public function getXmlContent(){
        $postArr = file_get_contents('php://input');
        if(empty($postArr)){
            return false;
        }
        $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

}