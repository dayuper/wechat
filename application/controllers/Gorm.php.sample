<?php

class GormController extends Base\ApplicationController {

    public function indexAction(){
       $table = $this->getParam('table','');
        define('APP_PATH', realpath(dirname(__FILE__)));
        $argv[] = '+d';
        $argv[] = 'default';
        $argv[] = '+N';
        $argv[] = 'M';
        $argv[] = '+f';  
        $argv[] = APPLICATION_PATH.'/application/library/M';
        if($table){
            $argv[] = '+t';
            $argv[] = $table;
        }
        $build  = new \Ormbuild\Build($argv);
        $build->before();
        $build->process();
        $build->after();
        unset($build);
        exit();
    }

}