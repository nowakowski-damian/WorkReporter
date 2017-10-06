<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 05/10/2017
 * Time: 10:33 PM
 */
class ReportAffirmation
{

    private $id;
    private $userId;
    private $date;
    private $vacation;

    /**
     * ReportAffirmation constructor.
     * @param $id
     * @param $userId
     * @param $date
     * @param $vacation
     */
    public function __construct($id, $userId, $date, $vacation)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->date = $date;
        $this->vacation = $vacation;
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
    public function isVacation()
    {
        return $this->vacation;
    }

    /**
     * @param mixed $vacation
     */
    public function setVacation($vacation)
    {
        $this->vacation = $vacation;
    }




}