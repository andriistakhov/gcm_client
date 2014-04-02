<?php
 
   //Storing new user and returns user details
    
   function storeUser($versionApp, $gcm_regid) {
    
        // insert user into database
        $result = mysql_query(
                      "INSERT INTO gcm_users
                            (version_app, gcm_regid, created_at) 
                            VALUES
                            ('$versionApp', 
                             '$gcm_regid', 
                             NOW())");
         
        // check for successful store
        if ($result) {
             
            // get user details
            $id = mysql_insert_id(); // last inserted id
            $result = mysql_query(
                               "SELECT * 
                                     FROM gcm_users 
                                     WHERE id = $id") or die(mysql_error());
            // return user details 
            if (mysql_num_rows($result) > 0) { 
                return mysql_fetch_array($result);
            } else {
                return false;
            }
             
        } else {
            return false;
        }
    }
 
    /**
     * Get user by version
     */  
    function getUserByVersion($version) {
        //$query="UPDATE ".$table." SET ";
        $result = mysql_query("SELECT * 
                                    FROM gcm_users 
                                    WHERE version_app =". $version);
        return $result;
    }
    
    function getRegIdsByVersion($version, $startOffset, $endOffset) {
        $result = mysql_query("SELECT gcm_regid 
                                    FROM gcm_users 
                                    WHERE version_app = $version 
                                    LIMIT $startOffset , $endOffset");
        return $result;
    }
 
    // Getting all registered users
  function getAllUsers() {
        $result = mysql_query("select * 
                                    FROM gcm_users");
        return $result;
    }
    
  function deleteAllUsers() {
        $result = mysql_query("DELETE FROM gcm_users");
        return $result;
    }
    
  function addVersionColumns() {
        $result = mysql_query("ALTER TABLE gcm_users ADD COLUMN version_app int(11) NOT NULL");
        return $result;
    }
    
  function dropColumns() {
        $result = mysql_query("ALTER TABLE gcm_users DROP COLUMN name");
        return $result;
    }
 
    // Validate user
  function isUserExisted($regId) {
        $result    = mysql_query("SELECT gcm_regid 
                                       from gcm_users 
                                       WHERE gcm_regid = '$regId'");
                                        
        $NumOfRows = mysql_num_rows($result);
        if ($NumOfRows > 0) {
            // user existed
            return true;
        } else {
            // user not existed
            return false;
        }
    }
     
    //Sending Push Notification
   function send_push_notification($versionApp, $message) {
         
         $resultUsers =  getUserByVersion($versionApp);
         $rowUsers = mysql_fetch_array($resultUsers);
         $NumOfUsers = mysql_num_rows($resultUsers); 
         
         // gcm can send message only to 1000 device per request 
         // see here  - http://pages.citebite.com/k9y2n5f8kmhp
         $gcmRequestLimit = 1000;
         
         $gcmRequestCount = 0; 
         if ($NumOfUsers > 0) {
            $gcmRequestCount  = ceil($NumOfUsers /1000);
         }else {
            // user not existed;
            echo "user not existed";
            return false;
         }
         
         for ($i = 1; $i <= $gcmRequestCount; $i++){

             $startOffset = $i * $gcmRequestLimit - $gcmRequestLimit;
             $tempArray = getRegIdsByVersion($versionApp, $startOffset, $i * $gcmRequestLimit  + 1);
             $registatoin_ids= array();
             $counter = 0;
             while($row = mysql_fetch_array($tempArray))
              {
                  if($row["gcm_regid"] != "" && $row["gcm_regid"] != "-")
                  {
                     $registatoin_ids[$counter] =  $row["gcm_regid"];
                     $counter ++;
                  }
              }
               
            // Set POST variables
            $url = 'https://android.googleapis.com/gcm/send';
     
            $fields = array(
                'registration_ids' => $registatoin_ids,
                'data' => $message,
            );
            //echo  json_encode( $fields);
            $headers = array(
                'Authorization: key=' . GOOGLE_API_KEY,
                'Content-Type: application/json'
            );
            //print_r($headers);
            // Open connection
            $ch = curl_init();
     
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
     
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
     
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
     
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
     
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
     
            // Close connection
            curl_close($ch);
        }
        return $result;
    }
    
    function send_back_notification($registatoin_ids, $message) {
         
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        //print_r($headers);
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        return $result;
    }
    
     function showJsonForDebug($version){
             
         $resultUsers =  getUserByVersion($version);
         
         $rowUsers = mysql_fetch_array($resultUsers);
         $NumOfUsers = mysql_num_rows($resultUsers); 
         $gcmRequestLimit = 1000;
         $registatoin_ids  = getRegIdsByVersion($version, 0, $gcmRequestLimit + 1);
         $jsonArray = array();
         $counter = 0;

         while($row = mysql_fetch_array($registatoin_ids))
          {
              echo "------------------------------------". "<br>";
              echo "gcm_regid - " . $row["gcm_regid"]. "<br>";
              echo "------------------------------------". "<br>";
              if($row["gcm_regid"] != "" && $row["gcm_regid"] != "-")
              {
                 $jsonArray[$counter] =  $row["gcm_regid"];
                 $counter ++;
              }
          }
         echo json_encode($jsonArray);
     }
?>