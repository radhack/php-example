<?php

//function askForRequestedArguments() {
//    $postArray = ($tmp = filter_input_array(INPUT_POST)) ? $tmp : Array();
//    return $postArray;
//}
function debug_to_console($data) {

    if (is_array($data))
        $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}

foreach ($_POST as $param_name => $param_val) {
    debug_to_console("Param: $param_name; Value: $param_val<br />\n");
}


echo 'Hello API Event Received';
