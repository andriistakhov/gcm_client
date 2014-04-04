<?php
 
 require_once('loader.php');
 
    $pushMessage = $_GET["message"];
    $versionApp  = $_GET["version"];
        
    if (isset($pushMessage)) {
         
        $message = array("message" => $pushMessage);
     
        $result = send_push_notification($versionApp, $message);
        echo $result;
    }
?>