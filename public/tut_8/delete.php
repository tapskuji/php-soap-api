<?php

require_once __DIR__ . '/../../config/bootstrap.php';

if (!isset($_GET['id'])) {
    redirect(url_for('/tut_8/index.php'));
}

$id = (int)$_GET['id'];

// This is your Web service server WSDL URL address
$wsdl = "http://localhost/tut_8/server.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$client->soap_defencoding = 'utf-8';
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

$operation = 'deleteTask';
$message = array('id' => $id);
$response = $client->call($operation, $message);
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

if ($response['status'] !== 'success') {
    exit($response['message']);
}

redirect(url_for('/tut_8/index.php'));