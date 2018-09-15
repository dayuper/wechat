<?php

namespace Ormbuild\Config;

class Db extends \Ormbuild\Config\ConfigAbstract {

    private  $_configFile = APPLICATION_PATH.'/conf/database.ini';
    public function init($adapter = 'default') {
        $conf = new \Yaf\Config\Ini(APPLICATION_PATH . '/conf/database.ini', \Yaf\Application::app()->environ());
        $connects = $options = $conf->get('resources.database');
        if (!$connects) {
            \Ormbuild\Lib\State::error('database.ini read fail');
        }
        if (isset($connects['multi'])) {
            $adapters = array_keys($connects['multi']->toArray());
            if(in_array($adapter,$adapters)){
                $options = $connects['multi'][$adapter];
            }else{
                \Ormbuild\Lib\State::error('the device is not found');
            }
        }
        return $options->toArray();
    }


}
