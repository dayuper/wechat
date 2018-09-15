<?php

namespace M;

trait Instance {

    protected static $_instance = null;

    private function __sleep(){}
    private function __clone(){}

    /**
     * 单例
     *
     * @return \M\Mapper\MapperAbstract
     */
    public static function getInstance(){
        if (!self::$_instance instanceof self){
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}

