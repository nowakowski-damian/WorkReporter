<?php

/**
 * Created by PhpStorm.
 * User: damian
 * Date: 01/04/2017
 * Time: 1:47 PM
 */
class Calendar
{
    const ARG_DAY = 'day';
    const ARG_MONTH = 'month';
    const ARG_YEAR = 'year';

    private $naviHref = null;
    private $currDay = 0;
    private $currMonth = 0;
    private $currYear = 0;

    public function __construct() {
        $this->naviHref = $_SERVER['PHP_SELF'];
    }


    public function show() {
        $this->initDateFields();
        $calendar = $this->getNavigationHeader();
        $calendar .= '<table>';
        $calendar .= $this->getWeekdaysTableRow();
        $calendar .= $this->getDaysTable($this->currYear, $this->currMonth);
        $calendar .= '</table> ';
        return $calendar;
    }


    private function initDateFields() {
        if( isset($_GET[self::ARG_DAY], $_GET[self::ARG_MONTH], $_GET[self::ARG_YEAR])
            && is_numeric($_GET[self::ARG_DAY]) && is_numeric($_GET[self::ARG_MONTH]) && is_numeric($_GET[self::ARG_YEAR]) ) {
            $this->currDay = htmlspecialchars($_GET[self::ARG_DAY]);
            $this->currMonth = htmlspecialchars($_GET[self::ARG_MONTH]);
            $this->currYear = htmlspecialchars($_GET[self::ARG_YEAR]);
        }
        else {
            $_GET[self::ARG_DAY] = $this->currDay = date("d");
            $_GET[self::ARG_MONTH] = $this->currMonth = date("m");
            $_GET[self::ARG_YEAR] = $this->currYear = date("Y");
        }
    }


    private function getNavigationHeader() {
        $header =
             '<div class="month">'.
                '<ul>'.
                    '<li class="prev"><a href='.$this->naviHref.$this->constructPreviousMonthGetQuery($this->currYear,$this->currMonth).'> &#10094;</a></li>'.
                    '<li class="next"><a href='.$this->naviHref.$this->constructNextMonthGetQuery($this->currYear,$this->currMonth).'> &#10095;</a></li>'.
                    '<li class="name">'.date("F",strtotime($this->currYear.'-'.$this->currMonth.'-01')).'<br>'.$this->currYear.'</li>'.
                '</ul>'.
            '</div>';
        return $header;
    }

    private function getWeekdaysTableRow() {
        $weekdays =
            '<tr class="weekdays">'.
                '<td>Mo</td>'.
                '<td>Tu</td>'.
                '<td>We</td>'.
                '<td>Th</td>'.
                '<td>Fr</td>'.
                '<td>Sa</td>'.
                '<td>Su</td>'.
            '</tr>';
        return $weekdays;
    }

    private function getDaysTable($year, $month) {
        $table = '<tr class="days">';
        $dayName = $this->getFirstDayNameNumber($year, $month) -1 ; // getFirstDayNameNumber() returns values: 0 (for Sunday) through 6 (for Saturday)
        if( $dayName==-1 ) {
            $dayName=6;
        }
        // empty day fields
        for( $i=0; $i<$dayName; $i++ ) {
            $table .='<td> </td>';
        }
        // regular day fields
        $daysInWeek = 0;
        for( $i=0; $i<$this->getNumOfDaysInMonth($year, $month); $i++ ) {
            if( ($dayName+$i)%7==0 ) {
                $table .= '</tr><tr class="days">';
                $daysInWeek = 0;
            }
            $daysInWeek++;
            $table .= $this->getDayTableItem( $year, $month, $i+1,($i+1)==$this->currDay );
        }
        // empty day fields
        for( $i=0; $i<7-$daysInWeek; $i++ ) {
            $table .='<td> </td>';
        }
        $table .= '</tr>';
        return $table;
    }

    private function getDayTableItem($year, $month, $day, $isSelected) {
        if( $isSelected ) {
            return '<td><span class="active"><a href='. $this->naviHref.$this->constructGetQuery($year, $month, $day) .'>'. $day .'</a></span></td>';
        }
        else {
            return '<td><a href='. $this->naviHref.$this->constructGetQuery($year, $month, $day) .'>'. $day .'</a></td>';
        }
    }

    private function getNumOfDaysInMonth($year, $month) {
        return date('t',strtotime($year.'-'.$month.'-01'));
    }

    private function getFirstDayNameNumber($year, $month) {
//        0 (for Sunday) through 6 (for Saturday)
        return date('w',strtotime($year.'-'.$month.'-01'));
    }

    private function constructNextMonthGetQuery($year, $month) {
        if( $month < 12 ) {
            $month++;
        }
        else {
            $month = 1;
            $year++;
        }
        return $this->constructGetQuery($year, $month, 1);
    }

    private function constructPreviousMonthGetQuery($year, $month) {
        if( $month > 1 ) {
            $month--;
        }
        else {
            $year--;
            $month = 12;
        }
        return $this->constructGetQuery($year, $month, 1);
    }

    private function constructGetQuery($year, $month, $day) {
        return '?'.self::ARG_YEAR.'='.$year.'&'.self::ARG_MONTH.'='.$month.'&'.self::ARG_DAY.'='.$day;
    }
}