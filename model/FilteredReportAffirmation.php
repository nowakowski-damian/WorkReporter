<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 22/09/2017
 * Time: 4:07 AM
 */
class FilteredReportAffirmation {

    private $userId;
    private $userFullName;
    private $isUserBlocked;
    private $userTotalTime;
    private $isVacation;

    /**
     * FilteredReportAffirmation constructor.
     * @param $userId
     * @param $userFullName
     * @param $isUserBlocked
     * @param $userTotalTime
     * @param $isVacation
     */
    public function __construct($userId, $userFullName, $isUserBlocked, $userTotalTime, $isVacation) {
        $this->userId = $userId;
        $this->userFullName = $userFullName;
        $this->isUserBlocked = $isUserBlocked;
        $this->userTotalTime = $userTotalTime;
        $this->isVacation = $isVacation;
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
    public function getUserFullName()
    {
        return $this->userFullName;
    }

    /**
     * @param mixed $userFullName
     */
    public function setUserFullName($userFullName)
    {
        $this->userFullName = $userFullName;
    }

    /**
     * @return mixed
     */
    public function isUserBlocked()
    {
        return $this->isUserBlocked;
    }

    /**
     * @param mixed $isUserBlocked
     */
    public function setIsUserBlocked($isUserBlocked)
    {
        $this->isUserBlocked = $isUserBlocked;
    }

    /**
     * @return mixed
     */
    public function getUserTotalTime()
    {
        return $this->userTotalTime;
    }

    /**
     * @param mixed $userTotalTime
     */
    public function setUserTotalTime($userTotalTime)
    {
        $this->userTotalTime = $userTotalTime;
    }

    /**
     * @return mixed
     */
    public function isVacation()
    {
        return $this->isVacation;
    }

    /**
     * @param mixed $isVacation
     */
    public function setIsVacation($isVacation)
    {
        $this->isVacation = $isVacation;
    }




}