<?php

class StaticFunctions
{
    /**
     * @param Train[] $trains
     * @return array
     */
    static public function getSumOfDelays($trains) {
        $delay = [];
        $delay['total_delay'] = 0;
        $delay['trains_count'] = count($trains);
        $delay['amount_on_time'] = 0;
        $delay['amount_late'] = 0;
        $delay['amount_early'] = 0;
        foreach($trains as $message) {
            $currentTrainDelay = (int)StaticFunctions::getBetween($message, '(', ' ');
            $delay['total_delay'] += $currentTrainDelay;
            if ($currentTrainDelay === 0){
                $delay['amount_on_time']++;
            } else if ($currentTrainDelay > 0) {
                $delay['amount_late']++;
            } else {
                $delay['amount_early']++;
            }
        }
        return $delay;
    }

    /**
     * @param $string
     * @param string $start
     * @param string $end
     * @return bool|string
     * Gets part of a string that is between 2 specified characters
     */
    static public function getBetween($string, $start = "", $end = ""){
        if (strpos($string, $start)) {
            $startCharCount = strpos($string, $start) + strlen($start);
            $firstSubStr = substr($string, $startCharCount, strlen($string));
            $endCharCount = strpos($firstSubStr, $end);
            if ($endCharCount == 0) {
                $endCharCount = strlen($firstSubStr);
            }
            return substr($firstSubStr, 0, $endCharCount);
        } else {
            return '';
        }
    }
}