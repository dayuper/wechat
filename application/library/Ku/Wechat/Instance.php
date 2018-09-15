<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-15
 * Time: 下午6:14
 */
namespace Ku\Wechat;
trait Instance{

    protected static $_instance = null;

    private function __sleep(){}
    private function __clone(){}

    /**
     * 单例
     */
    public static function getInstance(){
        if (!self::$_instance instanceof self){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

}