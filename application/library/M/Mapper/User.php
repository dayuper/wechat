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

    use \M\Instance;

    protected $modelClass = '\M\User';

    protected $table = 'user';

}