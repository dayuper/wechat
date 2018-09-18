<?php

namespace Business;

class BusinessAbstract {
    
    protected static $_message = null; 

    /**
     * 返回 Redis 实例
     *
     * @return \Redis|null
     */
    public function getRedis() {
        static $_redis = null;

        return $_redis ?: \Yaf\Registry::get('redis');
    }
    
    /**
     * 传递消息数据
     * @param int $code
     * @param string $msg
     * @param boolean $status
     * @param array $data
     * @param string $inputName 输入数据名词
     * @return boolean
     */
    protected function getMsg($code = 0, $msg = '',$status = false, $data = null) {
        if(!$msg){
            $msg = !isset(\Business\Errorconst::ERROR_MSG[$code])?\Business\Errorconst::ERROR_MSG[10000]:
                \Business\Errorconst::ERROR_MSG[$code];
        }
        $msgArr = array(
            'status' => (bool) $status === true ? true : false,
            'code' => (int) $code,
            'msg' => $msg,
        );

        if (!empty($data)) {
            $msgArr['data'] = $data;
        }   
        self::$_message = $msgArr;
        
        return $status;
    }
    
    
    public function getMessage(){
        return self::$_message;
    }
    
            // 静态页面的配置
    public function getApiDomain($conName) {
        $apiIni = \Yaf\Registry::get('apiini');
        if (!$apiIni) {
            $apiIni = new \Yaf\Config\Ini(APPLICATION_PATH . '/conf/api.ini', \Yaf\Application::app()->environ());
            \Yaf\Registry::set('apiini', $apiIni);
        }
        return $apiIni->get($conName);
    }
    
   /**
     * 取得当前配置
     *
     * @return \Yaf\Config\Ini
     */
    public function getConfig() {
        return \Yaf\Application::app()->getConfig();
    }
}
