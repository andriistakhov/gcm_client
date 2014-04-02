<?php
require_once('loader.php');

// return json response 
$json = array();

$versionApp = $_POST["version_app"];

// GCM Registration ID got from device
$gcmRegID = $_POST["regId"];

/**
* Registering a user device in database
* Store reg id in users table
*/
if (isset($versionApp) && isset($gcmRegID)) {


    // Store user details in db
    if(!isUserExisted($gcmRegID)){
        $res = storeUser($versionApp, $gcmRegID);

        //send push notification
        //$registatoin_ids = array($gcmRegID);
        //$message = array("message" => "device has been registerd in backend");

        //$result = send_back_notification($registatoin_ids, $message);
        //echo $result;
        echo "Device has been registered successfully";
    }else{
      echo "Device already registered";
    }
   
} else {
    // user details not found

}
?>