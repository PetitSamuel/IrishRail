<?php
require_once '../MySQL/DBConnection.php';
require '../Model/Train.php';

//print '[GETTING DART INFO FROM IRISH RAIL]' . PHP_EOL;
$dartData= simplexml_load_string(file_get_contents('http://api.irishrail.ie/realtime/realtime.asmx/getCurrentTrainsXML'));
$db = new DBConnection();

if(empty($db->getDb())) {
    die('Could not connect to database. Aborting');
}
//print '[STORING/UPDATING TRAIN DATA]' . PHP_EOL;
foreach ($dartData as $dart) {
    $train = new Train(
        $dart->TrainStatus,
        $dart->TrainLatitude,
        $dart->TrainLongitude,
        $dart->TrainCode,
        $dart->TrainDate,
        $dart->PublicMessage,
        $dart->Direction
    );
    $db->keepTrainRecord($train);
}
return [
  'status' => '200',
  'data' => $dartData
];
