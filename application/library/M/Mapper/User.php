<?php
/**
 * Created by PhpStorm.
 * User: Viter
 * Date: 2018/6/30
 * Time: 10:25
 */
namespace M\Mapper;

class User extends \M\Mapper\MapperAbstract
{

    use \Base\Model\InstanceModel;

    protected $modelClass = '';

    protected $table = 'user';

}