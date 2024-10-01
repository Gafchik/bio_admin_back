<?php

namespace App\Http\Classes\Structure;

use Carbon\Carbon as DateTimeClass;
use DatePeriod;
use DateInterval;

final class CDateTime
{
    public const DATE_FORMAT_DB = 'Y-m-d';
    public const DATE_FORMAT_PICKER = 'Y/m/d';
    public const DATE_FORMAT_DB_FD = 'Y-m-01';
    public const YEAR_MONTH_FORMAT_DB = 'Y-m';
    public const DATETIME_FORMAT_DB = 'Y-m-d H:i:s';
    public const DATE_TIME_MS_FORMAT_DB = 'Y-m-d H:i:s.v';
    public const DATE_TIME_FROM_REFERRAL_LINK = 'Y-m-d H:i:s:u';
    public const DATETIME_FORMAT_DB_ZONE = 'Y-m-d\TH:i:s';
    public const DATETIME_FORMAT_DB_ZONE_MS = 'Y-m-d\TH:i:s.u';
    public const DATE_FORMAT_PEOP = 'd.m.Y';
    public const TIME_FORMAT_PEOP = 'H.i';
    public const DATETIME_FORMAT_PEOP = 'd.m.Y H:i:s';
    public const SECONDS_IN_HOUR = 3600;
    public const HOURS_IN_A_DAY = 24;
    public const DATE_YEAR = 'Y';
    public const DATE_MONTH = 'm';
    public const DATE_DAY = 'd';
    public const DATE_1900 = '1900-01-01';
    public const DATE_INTERVAL_DEF = 'P1D';
    public const YEAR_MONTH_REG = '([0-9]{4})-([0-9]{2})';
    public const YYYY_MM_DD_DB = 'yyyy-MM-dd';
    public const TIME_FORMAT_INTERVAL = '%H:%I:%S';
    public const TIME_FORMAT_INTERVAL_MONTH = '%m';
    public const TIME_FORMAT_INTERVAL_DAYS = '%a';

    /**
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function getCurrentDate(string $format = self::DATETIME_FORMAT_DB) : string {
        return (new DateTimeClass())->format($format);
    }

    /**
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function getCurrentDateModified(string $modify = '+0 day', string $format = self::DATETIME_FORMAT_DB) : string {
        return (new DateTimeClass())->modify($modify)->format($format);
    }

    /**
     * @param $date
     * @param string $modify
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function getDateModified(string $date, string $modify = '+0 day', string $format = self::DATETIME_FORMAT_DB) : string {
        return (new DateTimeClass($date))->modify($modify)->format($format);
    }

    /**
     * @param string $format
     * @return mixed
     * @throws \Exception
     */
    public static function getCurrentDateTimeStamp() : int {
        return (new DateTimeClass())->getTimestamp();
    }

    /**
     * @param string $date
     * @return int
     */
    public static function convertDateToTimeStamp(string $date) : int {
        return (new DateTimeClass($date))->getTimestamp();
    }

    /**
     * @return DateTimeClass
     */
    public static function getFirstDayPreviousMonth(): DateTimeClass
    {
        return new DateTimeClass('first day of last month');
    }

    /**
     * @return DateTimeClass
     */
    public static function getLastDayPreviousMonth(): DateTimeClass
    {
        return new DateTimeClass('last day of last month');
    }

    /**
     * @param string|DateTimeClass $date
     * @return DateTimeClass
     */
    public static function convertDateToFirstDayOfMonth(string|DateTimeClass $date): DateTimeClass
    {
        return DateTimeClass::parse($date)->firstOfMonth();
    }

    /**
     * @param string|DateTimeClass $date
     * @return DateTimeClass
     */
    public static function convertDateToLastDayOfMonth(string|DateTimeClass $date): DateTimeClass
    {
        return DateTimeClass::parse($date)->endOfMonth();
    }

    /**
     * @param $date
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function convertDateToDateFormat(string $date, string $format = self::DATE_FORMAT_PEOP) : string {
        return (new DateTimeClass($date))->format($format);
    }

    /**
     * @param string $date
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function convertDateToTimeFormat(string $date, string $format = self::TIME_FORMAT_PEOP) : string {
        return (new DateTimeClass($date))->format($format);
    }

    /**
     * @param int|null $timestamp
     * @param string $format
     * @return string|null
     */
    public static function timestampToDateTime(?int $timestamp, string $format = self::DATETIME_FORMAT_DB) : ?string {
        return $timestamp ? DateTimeClass::parse($timestamp)->timezone(env('APP_TIMEZONE'))->format($format) : null;
    }
    /**
     * @return float
     */
    public static function microTimeFloat() : float {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    /**
     * @param string $date
     * @return array
     * @throws \Exception
     */
    public static function getYearMonth(string $date) : array
    {
        return [self::getYear($date), self::getMonth($date)];
    }

    /**
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function getYear(string $date) : string
    {
        return self::convertDateToDateFormat($date, self::DATE_YEAR);
    }

    /**
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function getMonth(string $date) : string
    {
        return self::convertDateToDateFormat($date, self::DATE_MONTH);
    }

    /**
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function getDay(string $date) : string
    {
        return self::convertDateToDateFormat($date, self::DATE_DAY);
    }

    /**
     * @param string|null $date
     * @return DateTimeClass|null
     */
    public static function getParsedDate(?string $date) : ?DateTimeClass
    {
        return $date ? DateTimeClass::parse($date) : null;
    }

    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $format
     * @param string $interval
     * @return array
     * @throws \Exception
     */
    public static function getDateRangeArray(string $startDate, string $endDate, string $format = self::DATETIME_FORMAT_DB, $interval = self::DATE_INTERVAL_DEF) : array {
        $datesPeriod = static::getDateRange($startDate, $endDate, $interval);
        $result = [];
        foreach ($datesPeriod as $index => $date) {
            $result[] = $date->format($format);
        }
        return $result;
    }
    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $interval
     * @return DatePeriod
     * @throws \Exception
     */
    public static function getDateRange(string $startDate, string $endDate, $interval = self::DATE_INTERVAL_DEF) : DatePeriod {
        return new DatePeriod(
            ( new DateTimeClass($startDate) )->setTime(0,0,0),
            new DateInterval($interval),
            ( new DateTimeClass($endDate) )->setTime(0,0,0)
        );
    }

    /**
     * @param string $format
     * @return string
     */
    public static function getFirstDateOfMonth(string $date, string $format = self::DATE_FORMAT_DB) : string {
        return (new DateTimeClass($date))->startOfMonth()->format($format);
    }

    /**
     * @param string $format
     * @return string
     */
    public static function getFirstDateOfNextMonth(string $date, string $format = self::DATE_FORMAT_DB) : string {
        return (new DateTimeClass($date))->modify('+1 month')->startOfMonth()->format($format);
    }

    /**
     * @param string $format
     * @return string
     */
    public static function getLastDateOfMonth(string $date, string $format = self::DATE_FORMAT_DB) : string {
        return (new DateTimeClass($date))->endOfMonth()->format($format);
    }

    /**
     * @param string $format
     * @return string
     */
    public static function getLastDateOfNextMonth(string $date, string $format = self::DATE_FORMAT_DB) : string {
        return (new DateTimeClass($date))->modify('+1 month')->endOfMonth()->format($format);
    }

    /**
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function getQuarterStartMonthByYearMonth(string $date) : int {
        $dateParse = static::getParsedDate($date);
        [$dateYear, $dateMonth] = static::getYearMonth($dateParse
            ? $dateParse->format(self::DATE_FORMAT_DB)
            : static::getCurrentDate());
        return static::getQuarterMonth((int)$dateMonth);
    }

    /**
     * @param string $date
     * @return string
     * @throws \Exception
     */
    public static function getQuarterMonthsByYearMonth(string $date) : array {
        $startMonth = static::getQuarterStartMonthByYearMonth($date);
        $result = [];
        for($i=1; $i<=3; $i++)
            $result[] = $startMonth++;
        return $result;
    }
    /**
     * @param string $startDate
     * @param string $endDate
     * @param string $format
     * @return string
     * @throws \Exception
     */
    public static function getTimeDifference(string $startDate, string $endDate, string $format = self::TIME_FORMAT_INTERVAL): string
    {
        return date_diff(
            static::getParsedDate($startDate),
            static::getParsedDate($endDate))
            ->format($format);
    }
    /**
     * @param int $month
     * @return int
     */
    private static function getQuarterMonth(int $month) : int {
        if ($month<=0 || $month>12)
            return 1;
        $res = gettype($month / 3) === 'double' ? (int)($month / 3) + 1 : $month / 3;
        return $res === 1 ? 1 : ($res - 1) * 3 + 1;
    }

    public static function getOnlyMonthDiff(string $startDate, string $endDate): int
    {
        return (int)DateTimeClass::parse(self::getFirstDateOfMonth($startDate))->floorMonth()
            ->floatDiffInMonths(DateTimeClass::parse(self::getFirstDateOfMonth($endDate))->floorMonth());
    }

    public static function getOnlyMinuteDiff(string $startDate, string $endDate): int
    {
        return (int)DateTimeClass::parse($startDate)->floorMinute()
            ->floatDiffInMinutes(DateTimeClass::parse($endDate)->floorMinute());
    }

    public static function getSeason(string $date)
    {
        $month = DateTimeClass::parse($date)->month;
        switch ($month) {
            case 12:
            case 1:
            case 2:
                return 'Winter';
            case 3:
            case 4:
            case 5:
                return 'Spring';
            case 6:
            case 7:
            case 8:
                return 'Summer';
            case 9:
            case 10:
            case 11:
                return 'Fall';
        }
    }
}


