<?php
/**
 * Created by PhpStorm.
 * User: chendongqin
 * Date: 18-9-18
 * Time: 下午7:25
 */

class RedirectController extends \Base\ApplicationController{


    public function indexAction(){
        $this->disableLayout();
        $this->disableView();
        $request = $this->getRequest();
        $params = $request->getPost();
        $gParam = $request->getQuery();
        $params = array_merge($params, $gParam);
        $action = $params['state'];
        $business = \Business\Redirect::getInstance();
        $res = $business->$action($params);
        var_dump($res);
        return false;
    }


}