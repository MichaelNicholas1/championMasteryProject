<?php

/** CSI 418
Modified from my CS410 - Intro to Databases Final Project
  */

//mysql://b2f22cc78246d9:99337e5a@us-cdbr-east-02.cleardb.com/heroku_884ad5524d74eb4?reconnect=true

$host       = "us-cdbr-east-02.cleardb.com";
$username   = "b2f22cc78246d9";
$password   = "99337e5a"; // this password will be changed when the database is uploaded to a webhosting service, for now its configured to the password of the local machine
$dbname     = "heroku_884ad5524d74eb4"; // will use later
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later
$api = "RGAPI-3dff7fd6-7191-4e64-a94a-8675cfbfae15";
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
              
?>