<?php
//require_once("model/RestHandler.php");
require __DIR__ . '/vendor/autoload.php';
$api=new RestHandler();
$api->send_data();