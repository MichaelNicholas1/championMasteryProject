<?php

/** CSI 418
Modified from my CS410 - Intro to Databases Final Project
  */

$host       = getenv('host');
$username   = getenv('username');
$password   = getenv('password'); // this password will be changed when the database is uploaded to a webhosting service, for now its configured to the password of the local machine
$dbname     = getenv('dbname'); // will use later
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later
$api = getenv('api');
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );
              
?>