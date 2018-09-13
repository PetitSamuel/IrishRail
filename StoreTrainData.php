<?php
require_once 'DBConnection.php';
require 'Train.php';

print '[GETTING DART INFO FROM IRISH RAIL]' . PHP_EOL;
$dartData= simplexml_load_string(file_get_contents('http://api.irishrail.ie/realtime/realtime.asmx/getCurrentTrainsXML'));
$db = new DBConnection();

if(empty($db->getDb())) {
    die('Could not connect to database. Aborting');
}
print '[STORING/UPDATING TRAIN DATA]' . PHP_EOL;
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
print '[PROCESS FINISHED] stored or updated ' . count($dartData) . ' trains.' . PHP_EOL;
?>

<form action="index.php">
    <input type="submit" value="Go Back" />
</form>
