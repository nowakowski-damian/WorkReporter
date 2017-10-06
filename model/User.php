<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 6:34 PM
 */
class User
{
    const ACC_TYPE_ROOT = 'root';
    const ACC_TYPE_USER = 'user';

    private $id;
    private $login;
    private $password;
    private $name;
    private $surname;
    private $account_type;
    private $blocked;


    /**
     * User constructor.
     * @param $id
     * @param $login
     * @param $password
     * @param $name
     * @param $surname
     * @param $account_type (user/root)
     */

    public function __construct($id, $login, $password, $name, $surname, $account_type, $blocked)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
        $this->account_type = $account_type;
        $this->blocked = $blocked;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->account_type;
    }

    /**
     * @param mixed $account_type
     */
    public function setAccountType($account_type)
    {
        $this->account_type = $account_type;
    }

    /**
     * @return mixed
     */
    public function isBlocked()
    {
        return $this->blocked;
    }

    /**
     * @param mixed $blocked
     */
    public function setBlocked($blocked)
    {
        $this->blocked = $blocked;
    }



    public function isRoot() {
        return @$this->account_type===User::ACC_TYPE_ROOT;
    }

    public function getFullName() {
        return $this->name." ".$this->surname." (".$this->login.")";
    }





}