<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 6:35 PM
 */
class Project
{
    private $id;
    private $customer_id;
    private $name;
    private $description;
    private $blocked;

    /**
     * Project constructor.
     * @param $id
     * @param $customer_id
     * @param $name
     * @param $description
     * @param $blocked
     */
    public function __construct($id, $customer_id, $name, $description, $blocked)
    {
        $this->id = $id;
        $this->customer_id = $customer_id;
        $this->name = $name;
        $this->description = $description;
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
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * @param mixed $customer_id
     */
    public function setCustomerId($customer_id)
    {
        $this->customer_id = $customer_id;
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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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



}