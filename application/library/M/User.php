<?php

/**
 * User
 * 
 * @Table Schema: dayup
 * @Table Name: user
 */
namespace M;

class User extends \M\ModelAbstract {

    /**
     * Params
     * 
     * @var array
     */
    protected $_params = null;

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @var int
     */
    protected $_id = null;

    /**
     * User_name
     * 
     * Column Type: varchar(45)
     * 
     * @var string
     */
    protected $_user_name = '';

    /**
     * Password
     * 
     * Column Type: varchar(60)
     * 
     * @var string
     */
    protected $_password = '';

    /**
     * OpenId
     * 
     * Column Type: varchar(100)
     * 
     * @var string
     */
    protected $_openId = '';

    /**
     * Create_time
     * 
     * Column Type: bigint(20) unsigned
     * Default: 0
     * 
     * @var int
     */
    protected $_create_time = 0;

    /**
     * Update_time
     * 
     * Column Type: bigint(20) unsigned
     * Default: 0
     * 
     * @var int
     */
    protected $_update_time = 0;

    /**
     * 关注状态1关注2绑定0取关
     * 
     * Column Type: tinyint(1) unsigned
     * Default: 1
     * 
     * @var int
     */
    protected $_status = 1;

    /**
     * Params
     * 
     * Column Type: array
     * Default: null
     * 
     * @var array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @param int $id
     * @return \M\User
     */
    public function setId($id) {
        $this->_id = (int)$id;
        $this->_params['id'] = (int)$id;
        return $this;
    }

    /**
     * Id
     * 
     * Column Type: int(11)
     * auto_increment
     * PRI
     * 
     * @return int
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * User_name
     * 
     * Column Type: varchar(45)
     * 
     * @param string $user_name
     * @return \M\User
     */
    public function setUser_name($user_name) {
        $this->_user_name = (string)$user_name;
        $this->_params['user_name'] = (string)$user_name;
        return $this;
    }

    /**
     * User_name
     * 
     * Column Type: varchar(45)
     * 
     * @return string
     */
    public function getUser_name() {
        return $this->_user_name;
    }

    /**
     * Password
     * 
     * Column Type: varchar(60)
     * 
     * @param string $password
     * @return \M\User
     */
    public function setPassword($password) {
        $this->_password = (string)$password;
        $this->_params['password'] = (string)$password;
        return $this;
    }

    /**
     * Password
     * 
     * Column Type: varchar(60)
     * 
     * @return string
     */
    public function getPassword() {
        return $this->_password;
    }

    /**
     * OpenId
     * 
     * Column Type: varchar(100)
     * 
     * @param string $openId
     * @return \M\User
     */
    public function setOpenId($openId) {
        $this->_openId = (string)$openId;
        $this->_params['openId'] = (string)$openId;
        return $this;
    }

    /**
     * OpenId
     * 
     * Column Type: varchar(100)
     * 
     * @return string
     */
    public function getOpenId() {
        return $this->_openId;
    }

    /**
     * Create_time
     * 
     * Column Type: bigint(20) unsigned
     * Default: 0
     * 
     * @param int $create_time
     * @return \M\User
     */
    public function setCreate_time($create_time) {
        $this->_create_time = (int)$create_time;
        $this->_params['create_time'] = (int)$create_time;
        return $this;
    }

    /**
     * Create_time
     * 
     * Column Type: bigint(20) unsigned
     * Default: 0
     * 
     * @return int
     */
    public function getCreate_time() {
        return $this->_create_time;
    }

    /**
     * Update_time
     * 
     * Column Type: bigint(20) unsigned
     * Default: 0
     * 
     * @param int $update_time
     * @return \M\User
     */
    public function setUpdate_time($update_time) {
        $this->_update_time = (int)$update_time;
        $this->_params['update_time'] = (int)$update_time;
        return $this;
    }

    /**
     * Update_time
     * 
     * Column Type: bigint(20) unsigned
     * Default: 0
     * 
     * @return int
     */
    public function getUpdate_time() {
        return $this->_update_time;
    }

    /**
     * 关注状态1关注2绑定0取关
     * 
     * Column Type: tinyint(1) unsigned
     * Default: 1
     * 
     * @param int $status
     * @return \M\User
     */
    public function setStatus($status) {
        $this->_status = (int)$status;
        $this->_params['status'] = (int)$status;
        return $this;
    }

    /**
     * 关注状态1关注2绑定0取关
     * 
     * Column Type: tinyint(1) unsigned
     * Default: 1
     * 
     * @return int
     */
    public function getStatus() {
        return $this->_status;
    }

    /**
     * Return a array of model properties
     * 
     * @return array
     */
    public function toArray() {
        return array(
            'id'          => $this->_id,
            'user_name'   => $this->_user_name,
            'password'    => $this->_password,
            'openId'      => $this->_openId,
            'create_time' => $this->_create_time,
            'update_time' => $this->_update_time,
            'status'      => $this->_status
        );
    }

}
