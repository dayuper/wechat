<?php

namespace Base;

class ApplicationController extends \Base\AbstractController {



    protected function before() {
        $this->disableView();
        $this->disableLayout();
    }

    protected function isFilter(){
    }

    protected function after() {

    }

    /**
     * @return \MongoClient
     * @throws \Exception
     * 
     */
    public function getMongo() {
        $mongodb = \Yaf\Registry::get('mongodb');
        return $mongodb;
    }

    /**
     * 
     * @return \Redis
     * @throws \Exception
     */
    public function getRedis() {
        $redis = \Yaf\Registry::get('redis');
        return $redis;
    }

    /**
     * 创建校验码
     * @param array $params
     * @return string
     */
    protected function createSignature($params) {
        $codeArr = array();
        foreach ($params as $key => $value) {
            $codeArr[$key] = $key . '=' . $value;
        }
        ksort($codeArr);
        $config = \Yaf\Registry::get('config');
        return md5(implode('', $codeArr) . $config->get('encryption.appsecret'));
    }

    protected function getToken($input = array()) {
        $request = $this->getRequest();
        $server = $request->getServer();
        $ip = \Ku\Tool::getClientIp();
        $data['ua'] = !isset($server['HTTP_USER_AGENT'])? : $server['HTTP_USER_AGENT'];
        $data['ip'] = $ip;
        if ($input) {
            $data = array_merge($data, $input);
        }
        return $this->createSignature($data);
    }
}
