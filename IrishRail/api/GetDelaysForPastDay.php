<?php
require_once '../MySQL/DBConnection.php';
require '../Model/Train.php';
require '../Common/StaticFunctions.php';

//print '[GETTING DART INFO FROM Database]' . PHP_EOL;
$db = new DBConnection();
if(empty($db->getDb())) {
    die('Could not connect to database. Aborting');
}
$date = new DateTime();
$date->modify('-1 day');
//print '[PROCESSING TRAIN DATA]' . PHP_EOL;
$delays = $db->fetchAllDelayFromYesterday($date);
$result = StaticFunctions::getSumOfDelays($delays);
$db->storeDailyTrainRecap($result, $date);
//print '[FINISHED]' . PHP_EOL;
//print_r($result);
retun [
  'status' => '200',
  'data' => $result
]
?>
