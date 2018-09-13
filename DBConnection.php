<?php

class DBConnection
{
    /**
     * Database connection
     * @var mixed
     */
    private $db;

    public function __construct()
    {
        if(!$this->db = mysql_connect(
            'userweb.netsoc.tcd.ie',
            'petits',
            'Ohr4Kiey'
        )) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not connect to database ' . mysql_error() . PHP_EOL, FILE_APPEND);
            $this->db = false;
        }
    }

    /**
     * @return bool
     */
    public function getDb()
    {
        return $this->db;
    }

    public function keepTrainRecord(Train $train) {
        $record = mysql_query("SELECT id FROM irishrail.trains WHERE code='" . $train->getCode() . "'");
        if (!$record) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . 'could not execute query' . mysql_error() . PHP_EOL, FILE_APPEND);
        }

        if((int)mysql_num_rows($record) === 0) {
            $this->insertTrainRecord($train);
        }
        else {
            $result = mysql_fetch_assoc($record);
            $this->updateTrainRecord($train, $result['id']);
        }
    }
    public function insertTrainRecord(Train $train) {
        if(!mysql_query( 'INSERT INTO irishrail.trains (status, latitude, longitude, code, date, message, direction) ' .
            "VALUES ('" . $train->getStatus() ."'," . $train->getLatitude(). "," . $train->getLongitude() . ",'" . $train->getCode() .
            "','" . $train->getDate() . "','" . $train->getMessage() . "','" . $train->getDirection() . "')")) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not execute insert ' . mysql_error($this->db) . PHP_EOL, FILE_APPEND);
        }
    }
    public function updateTrainRecord(Train $train, $id) {
        if(!mysql_query( "UPDATE irishrail.trains SET status='" . $train->getStatus() . "', latitude=" . $train->getLatitude() . ", longitude=" . $train->getLongitude() . ", message='" . $train->getMessage() .
            "' WHERE id=" . $id)) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not execute update ' . mysql_error($this->db) . PHP_EOL, FILE_APPEND);
        }
    }

    public function fetchAllDelayFromYesterday (DateTime $date) {
        $result = mysql_query( "SELECT message FROM irishrail.trains WHERE status='T' AND date='" . $date->format('d M Y') . "'");
        $delays = [];
        while ($record = mysql_fetch_assoc($result)) {
            $delays[] = $record['message'];
        }
        return $delays;
    }

    public function storeDailyTrainRecap($data, DateTime $date) {
        if(!mysql_query( 'INSERT INTO irishrail .daily_recap (date, total_delay, on_time_trains, early_trains, late_trains, total_trains) ' .
            "VALUES ('" . $date->format('Y-m-d') ."'," . $data['total_delay'] . "," . $data['amount_on_time']. ", " . $data['amount_early'] .
            "," . $data['amount_late'] . "," . $data['trains_count'] . ")")) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not execute insert ' . mysql_error($this->db) . PHP_EOL, FILE_APPEND);
        }
    }
}