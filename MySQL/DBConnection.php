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
        if(!$this->db = mysqli_connect(
          '127.0.0.1',
          'root',
          'root',
          'irishrail',
          '3306'
        )) {
          die(' Could not connect to database ' . mysqli_connect_error());
            file_put_contents('/log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not connect to database ' . mysqli_connect_error() . PHP_EOL, FILE_APPEND);
            $this->db = false;
        }
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /*
      Checks if current train already is stored in database then decides wether to update its data or store a new entry
    */
    public function keepTrainRecord(Train $train) {
        $record = mysqli_query($this->db,
            "SELECT id FROM trains WHERE code='" . $train->getCode() . "'");
        if((int)$record->num_rows === 0) {
            $this->insertTrainRecord($train);
        }
        else {
            $result = $record->fetch_assoc();
            $this->updateTrainRecord($train, $result['id']);
        }
    }

    public function insertTrainRecord(Train $train) {
        if(!mysqli_query($this->db, 'INSERT INTO trains (status, latitude, longitude, code, date, message, direction) ' .
            "VALUES ('" . $train->getStatus() ."'," . $train->getLatitude(). "," . $train->getLongitude() . ",'" . $train->getCode() .
            "','" . $train->getDate() . "','" . $train->getMessage() . "','" . $train->getDirection() . "')")) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not execute insert ' . mysqli_error($this->db) . PHP_EOL, FILE_APPEND);
        }
    }

    public function updateTrainRecord(Train $train, $id) {
        if(!mysqli_query($this->db, "UPDATE trains SET status='" . $train->getStatus() . "', latitude=" . $train->getLatitude() . ", longitude=" . $train->getLongitude() . ", message='" . $train->getMessage() .
            "' WHERE id=" . $id)) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not execute update ' . mysqli_error($this->db) . PHP_EOL, FILE_APPEND);
        }
    }

    /*
      Gets all trains that terminated yesterday
    */
    public function fetchAllDelayFromYesterday (DateTime $date) {
        $result = mysqli_query($this->db, "SELECT message FROM trains WHERE status='T' AND date='" . $date->format('d M Y') . "'");
        $delays = [];
        while ($record = $result->fetch_assoc()) {
            $delays[] = $record['message'];
        }
        return $delays;
    }

    /*
      Stores a recap of the day from data stored in our DB.
    */
    public function storeDailyTrainRecap($data, DateTime $date) {
        if(!mysqli_query($this->db, 'INSERT INTO .daily_recap (date, total_delay, on_time_trains, early_trains, late_trains, total_trains) ' .
            "VALUES ('" . $date->format('Y-m-d') ."'," . $data['total_delay'] . "," . $data['amount_on_time']. ", " . $data['amount_early'] .
            "," . $data['amount_late'] . "," . $data['trains_count'] . ")")) {
            file_put_contents('log/logs.txt', $date = date('m/d/Y h:i:s a', time()) . ' Could not execute insert ' . mysqli_error($this->db) . PHP_EOL, FILE_APPEND);
        }
    }
}
