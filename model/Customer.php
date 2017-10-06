<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 6:35 PM
 */
class Customer
{

    private $id;
    private $name;
    private $address;
    private $blocked;

    /**
     * Customer constructor.
     * @param $id
     * @param $name
     * @param $address
     * @param $blocked
     */
    public function __construct($id, $name, $address, $blocked)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
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


    public function getFullName() {
        return $this->name.", ".$this->address;
    }

}