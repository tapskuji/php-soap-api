<?php

require_once __DIR__ . '/../../config/bootstrap.php';

//Create a new soap server
$server = new soap_server();

//Define our namespace
$namespace = "http://localhost/soap/helloworldservice";
$server->wsdl->schemaTargetNamespace = $namespace;

//Configure our WSDL
$serviceName = "HelloWorldService";
$server->configureWSDL($serviceName, $namespace);

// Register the "hello" method to expose it
$server->register(
    'hello',                               // function name (required)
    array('username' => 'xsd:string'),     // parameter (required)
    array('return' => 'xsd:string'),       // output (required)
    $namespace,                            // namespace
    $namespace.'#helloWorld',              // soapaction
    'rpc',                                 // style
    'encoded',                             // use
    'Simple hello with name parameter'     // description
);

function hello($username)
{
    return "Hello, $username!";
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit();
