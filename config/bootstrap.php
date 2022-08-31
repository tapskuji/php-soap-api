<?php

ini_set('display_errors', 0);
//ini_set("soap.wsdl_cache_enabled", "0");
error_reporting(-1);
define('ABSPATH', dirname(__DIR__));

if (strpos($_SERVER['SCRIPT_NAME'], '/public') !== FALSE) {
    $public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
    $doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
} else {
    $doc_root = "";
}

define("WWW_ROOT", $doc_root);

$tutorials = array(
    1 => array('name' => 'Tutorial 1', 'url' => '/tut_1/client.php', 'wsdl' => '/tut_1/server.php', 'wsdl_location' => '/tut_1/server.php?wsdl'),
    2 => array('name' => 'Tutorial 2', 'url' => '/tut_2/client.php', 'wsdl' => '/tut_2/server.php', 'wsdl_location' => '/tut_2/server.php?wsdl'),
    3 => array('name' => 'Tutorial 3', 'url' => '/tut_3/client.php', 'wsdl' => '/tut_3/server.php', 'wsdl_location' => '/tut_3/server.php?wsdl'),
    4 => array('name' => 'Tutorial 4', 'url' => '/tut_4/client.php', 'wsdl' => '/tut_4/server.php', 'wsdl_location' => '/tut_4/server.php?wsdl'),
    5 => array('name' => 'Tutorial 5', 'url' => '/tut_5/client.php', 'wsdl' => '/tut_5/server.php', 'wsdl_location' => '/tut_5/server.php?wsdl'),
    6 => array('name' => 'Tutorial 6', 'url' => '/tut_6/client.php', 'wsdl' => '/tut_6/server.php', 'wsdl_location' => '/tut_6/server.php?wsdl'),
    7 => array('name' => 'Tutorial 7', 'url' => '/tut_7/client.php', 'wsdl' => '/tut_7/server.php', 'wsdl_location' => '/tut_7/server.php?wsdl'),
    8 => array('name' => 'Tutorial 8', 'url' => '/tut_8/index.php', 'wsdl' => '/tut_8/server.php', 'wsdl_location' => '/tut_8/server.php?wsdl'),
);

require_once ABSPATH . '/config/functions.php';
require_once ABSPATH . '/lib/nusoap/lib/nusoap.php';