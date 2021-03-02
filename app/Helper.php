<?php


function humanTiming ($time) {

    $timestamp = $time;	

    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
            $diff = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
    } else {
        $diff = $timestamp-time();
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
        $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return "Time remaining: ".$diff . " " . $strTime[$i] . "(s)";
    }

}

function array_values_recursive( $array ) {
    $array = array_values( $array );
    for ( $i = 0, $n = count( $array ); $i < $n; $i++ ) {
        $element = $array[$i];
        if ( is_array( $element ) ) {
            $array[$i] = array_values_recursive( $element );
        }
    }
    return $array;
}

?>