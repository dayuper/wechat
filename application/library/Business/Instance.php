<?php

namespace Business;

trait Instance {

    protected static $_instance = null;

    private function __sleep(){}
    private function __clone(){}

    /**
     * 单例
     *
     * @return \Business\BusinessAbstract
     */
    public static function getInstance(){
        if (!self::$_instance instanceof self){
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

