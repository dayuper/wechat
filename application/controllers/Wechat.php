<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-15
 * Time: 下午7:16
 */
class WechatController extends \Base\ApplicationController
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
        if($res === false){
            echo 'fail';
            exit();
        }
        $content = $wechat->getXmlContent();
        if($content === false){
            echo $echostr;
            exit();
        }
        $xml = $wechat->act($content);
        echo $xml;
        exit();
    }


    public function menuAction(){
        $wechat = \Ku\Wechat\Wechat::getInstance();
        $menu = array(
            'button'=>array(
                array('type'=>'view','name'=>'关于我们','url'=>'http://ball.cddong.top'),
                array(
                    'name'=>'小游戏','sub_button'=>array(
                        array('type'=>'view','name'=>'博饼小游戏','url'=>'http://ball.cddong.top'),
                        array('type'=>'location_select','name'=>'发送位置','key'=>'cdq1995_001')
                    )
                ),
                array( 'name'=>'更多','sub_button'=>array(
                    array('type'=>'click','name'=>'认证','key'=>'cdq1995_002'),
                    array('type'=>'scancode_waitmsg','name'=>'扫码带提示','key'=>'cdq1995_003'),
                    array('type'=>'scancode_push','name'=>'扫码推事件','key'=>'cdq1995_004')
                ))
            )
        );
        $res = $wechat->createMenu($menu);
        var_dump($res);
    }

    public function testAction(){
        $redis = $this->getRedis();
        $channel = $this->getParam('channel','','int');
        if(empty($channel)){
            return $this->returnData('channel不存在');
        }
        $ticketKey = 'ticket.test.'.$channel;
        $wechat = \Ku\Wechat\Wechat::getInstance();
        $ticket = $redis->get($ticketKey);
        if($ticket){
            $url = $wechat->qrcodeForTicket($ticket);
        }else{
            $param = array(
                'action_name'=>'QR_SCENE','expire_seconds'=>604800,'action_info'=>array('scene'=>array('scene_id'=>$channel))
            );
            $res = $wechat->qrcode($param);
            $res = json_decode($res,true);
            if(isset($res['url'])){
                $url = $wechat->qrcodeForTicket($res['ticket']);
                $redis->set($ticketKey,$res['ticket'],$res['expire_seconds']-2);
            }else{
                $url = '';
            }
        }
//        header('Content-type:image.jpg');
//        $hander = curl_init();
//        curl_setopt($hander,CURLOPT_URL,$url);
//        curl_setopt($hander,CURLOPT_HEADER,0);
//        curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
//        //curl_setopt($hander,CURLOPT_RETURNTRANSFER,false);//以数据流的方式返回数据,当为false是直接显示出来
//        curl_setopt($hander,CURLOPT_TIMEOUT,60);
//        $response = curl_exec($hander);
//        curl_close($hander);
//        echo $response;
        echo "<img src='$url'>";
    }




}