<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 05/09/2017
 * Time: 11:13 PM
 */
class FilteredReport {

    private $id;
    private $user;
    private $userId;
    private $customer;
    private $customerId;
    private $project;
    private $projectId;
    private $time;
    private $date;

    /**
     * FilteredReport constructor.
     * @param $id
     * @param $user
     * @param $userId
     * @param $customer
     * @param $customerId
     * @param $project
     * @param $projectId
     * @param $time
     * @param $date
     */
    public function __construct($id, $user, $userId, $customer, $customerId, $project, $projectId, $time, $date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->userId = $userId;
        $this->customer = $customer;
        $this->customerId = $customerId;
        $this->project = $project;
        $this->projectId = $projectId;
        $this->time = $time;
        $this->date = $date;
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param mixed $project
     */
    public function setProject($project)
    {
        $this->project = $project;
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * @param mixed $projectId
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
    }

    /**
     * @return mixed
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }




}