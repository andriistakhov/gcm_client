<?php
require_once('config.php');
require_once('function.php');
 
// connecting to mysql
header('Content-Type: application/json; charset=utf-8');
require('../../wp-load.php' );
global $wpdb;
if (!$wpdb) {
    echo('Error: ' . mysql_error());
}
// На этом примере смотри как выбирать данные из сервера! 
// json_encode($city);
// echo $json;
// }
// catch(Exception $e) {
//     echo 'Caught exception: '.  $e->getMessage(). "\n";
// }
?>
