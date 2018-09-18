<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-15
 * Time: 下午6:07
 */
namespace Ku\Wechat;

class Wechat extends BaseAbstract {
    use Instance;

    private $_api = 'https://api.weixin.qq.com/';
    private $_openApi = 'https://open.weixin.qq.com/';
    private $_appId = '';
    private $_appSecret = '';
    private $_wechatToken = '';

    public function __construct()
    {
        $config = \Yaf\Registry::get('config');
        $conf = $config->get('resources.wechat');
        if (!isset($conf['appid']) || !isset($conf['appsecret'])) {
            throw new \Exception('微信未配置');
        }
        $this->_appId = $conf['appid'];
        $this->_appSecret = $conf['appsecret'];
        $this->_wechatToken = $conf['token'];
    }

    /**信息认证
     * @param $timeStamp
     * @param $nonce
     * @param $signature
     * @return bool
     */
    public function checkSignatrue($timeStamp,$nonce,$signature){
        $token = $this->_wechatToken;
        $array = array($timeStamp,$nonce,$token);
        sort($array, SORT_STRING);
        $tmpstr = implode('',$array);
        $tmpstr = sha1($tmpstr);
        if($tmpstr == $signature){
            return true;
        }
        return false;

    }

    /**获取token
     * @param bool $freshen
     * @return bool|string
     */
    public function getAccessToken($freshen=false){
        $redis = $this->getRedis();
        $tokenKey = 'access.token.'.$this->_appId;
        if($freshen === false){
            $token = $redis->get($tokenKey);
            if($token !== false){
                return $token;
            }
        }
        $url = $this->_api.'cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';
        $url = sprintf($url,$this->_appId,$this->_appSecret);
        $http = new \Ku\Http();
        $http->setUrl($url);
        $send = $http->send();
        if(!$send){
            return $this->getMsg(300,'请求超时');
        }
        $result = json_decode($send,true);
        if(!isset($result['access_token'])){
            return $this->getMsg($result['errcode'],$result['errmsg']);
        }
        $redis->set($tokenKey,$result['access_token'],7199);
        return $result['access_token'];
    }

    /**获取消息
     * @return array|bool
     */
    public function getXmlContent(){
        $postArr = file_get_contents('php://input');
        if(empty($postArr)){
            return false;
        }
        $postObj = simplexml_load_string($postArr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $content = [];
        $content['from_user_name'] = (string) isset($postObj->FromUserName)?$postObj->FromUserName:'';
        $content['to_user_name'] = (string) isset($postObj->ToUserName)?$postObj->ToUserName:'';
        $content['location_X'] = (string) isset($postObj->Location_X)?$postObj->Location_X:'';
        $content['location_Y'] = (string) isset($postObj->Location_Y)?$postObj->Location_Y:'';
        $content['msg_type'] = (string) isset($postObj->MsgType)?$postObj->MsgType:'';
        $content['keyword'] = (string) isset($postObj->keyword)?trim($postObj->keyword):'';
        $content['event'] = (string) isset($postObj->Event)?$postObj->Event:'';
        $content['event_key'] = (string) isset($postObj->EventKey)?$postObj->EventKey:'';
        $content['pic_url'] = (string) isset($postObj->PicUrl)?$postObj->PicUrl:'';
        $content['content'] = (string) isset($postObj->Content)?$postObj->Content:'';
        return $content;
    }

    /**动作处理
     * @param $content
     * @return string
     */
    public function act($content){
        $xml = '';
        switch ($content['msg_type']) {
            case "event":
                $event = $content['event'];
                switch ($event) {
                    //普通扫描（已关注）
                    case 'SCAN':
                        break;
                    //关注
                    case 'subscribe':
                        $xml = $this->textXml($content,'text','欢迎您加入我们');
                        break;
                    //取消关注
                    case 'unsubscribe':

                        break;
                    case 'CLICK':
                        if($content['event_key'] == 'cdq1995_002'){
                            $url = $this->authorize('http://wechat.cddong.top?action=authorize');
                            $xml = $this->textXml($content,'text',"<a href=\"$url\">点击认证~</a>");
                        }
                        break;
                }
                break;
            //回复文字消息
            case 'text':
               $xml = $this->textXml($content,'text','你好');
        }
        return $xml;
    }

    /**消息回复
     * @param $content
     * @param string $type
     * @param string $answer
     * @return string
     */
    public function textXml($content,$type = 'text',$answer = ''){
        $data['ToUserName'] = $content['from_user_name'];
        $data['FromUserName'] = $content['to_user_name'];
        $data['CreateTime'] = time();
        switch ($type){
            case 'text':
                $data['MsgType'] = 'text';
                $data['Content'] = $answer;
                $xml = $this->data2Xml($data);
                break;
            default:
                return '';
                break;
        }
        return $xml;
    }

    /**将数组转化为xml
     * @param $data
     * @param bool $root
     * @return string
     */
    public function data2Xml($data, $root = true){
        $str="";
        if($root)$str .= "<xml>";
        foreach($data as $key => $val){
            if(is_array($val)){
                $child = $this->arr2xml($val, false);
                $str .= "<$key>$child</$key>";
            }else{
                $str.= "<$key><![CDATA[$val]]></$key>";
            }
        }
        if($root)$str .= "</xml>";
        return $str;
    }



    /**创建菜单
     * @param $createMue
     * @return bool
     */
    public function createMenu($createMenu){
        if(empty($createMenu)){
            return $this->getMsg(500,'新增菜单不能为空');
        }
        $token = $this->getAccessToken();
        $url = $this->_api.'cgi-bin/menu/create?access_token='.$token;
        $http = new \Ku\Http();
        $http->setUrl($url);
        $http->setParam($createMenu,true,true);
        $res = $http->postJson();
        if(!$res){
            return $this->getMsg(300,'请求超时');
        }
        $result = json_decode($res,true);
        if($result['errcode'] ==0){
            return true;
        }
        return $this->getMsg($result['errcode'],$result['errmsg']);
    }

    /**菜单查询
     * @return bool
     */
    public function selectMenu(){
        $token = $this->getAccessToken();
        $url = $this->_api.'cgi-bin/menu/get?access_token='.$token;
        $http = new \Ku\Http();
        $http->setUrl($url);
        $res = $http->send();
        if(!$res){
            return $this->getMsg(300,'请求超时');
        }
        $result = json_decode($res,true);
        if(!isset($result['menu'])){
            return $this->getMsg(500,'没有菜单');
        }
        return $result['menu'];
    }

    /**删除菜单
     * @return bool
     */
    public function delMenu(){
        $token = $this->getAccessToken();
        $url = $this->_api.'cgi-bin/menu/delete?access_token='.$token;
        $http = new \Ku\Http();
        $http->setUrl($url);
        $res = $http->send();
        if(!$res){
            return $this->getMsg(300,'请求超时');
        }
        $result = json_decode($res,true);
        if($result['errcode'] ==0){
            return true;
        }
        return $this->getMsg($result['errcode'],$result['errmsg']);
    }

    /**获取授权code
     * @param $returnUrl
     * @param string $scope snsapi_base|snsapi_userinfo
     * @param string $state
     * @return string
     */
    public function authorize($returnUrl , $scope = 'snsapi_userinfo' , $state = 'STATE'){
        $url = $this->_openApi.'/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect';
        $url = sprintf($url,$this->_appId,urlencode($returnUrl),$scope,$state);
        return $url;
    }

    /**通过code换取网页授权access_token
     * @param $code
     * @return array|\Ku\json|null|Object|string
     */
    public function code2AccessToken($code){
        $url = $this->_api.'/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';
        $url = sprintf($url,$this->_appId,$this->_appSecret,$code);
        $http = new \Ku\Http();
        $http->setUrl($url);
        $res = $http->send();
        return $res;
    }

}