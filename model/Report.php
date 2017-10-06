<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 12/04/2017
 * Time: 6:34 PM
 */
class Report
{
    private $id;
    private $user_id;
    private $project_id;
    private $customer_id;
    private $date;
    private $time_hours;
    private $description;

    /**
     * Report constructor.
     * @param $id
     * @param $user_id
     * @param $project_id
     * @param $customer_id
     * @param $date
     * @param $time_hours
     * @param $description
     */
    public function __construct($id, $user_id, $project_id, $customer_id, $date, $time_hours, $description)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->project_id = $project_id;
        $this->customer_id = $customer_id;
        $this->date = $date;
        $this->time_hours = $time_hours;
        $this->description = $description;
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
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->project_id;
    }

    /**
     * @param mixed $project_id
     */
    public function setProjectId($project_id)
    {
        $this->project_id = $project_id;
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

    /**
     * @return mixed
     */
    public function getTimeHours()
    {
        return $this->time_hours;
    }

    /**
     * @param mixed $time_hours
     */
    public function setTimeHours($time_hours)
    {
        $this->time_hours = $time_hours;
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


}