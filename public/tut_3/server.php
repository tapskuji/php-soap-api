<?php

require_once __DIR__ . '/../../config/bootstrap.php';

//Create a new soap server
$server = new soap_server();

//Define our namespace
$namespace = "http://localhost/soap/currencyconverterservice";
$server->wsdl->schemaTargetNamespace = $namespace;

//Configure our WSDL
$serviceName = "CurrencyConverter";
$server->configureWSDL($serviceName, $namespace);

// Register the "register" method to expose it
$server->register(
    'convertCurrency',                                        // function name (required)
    array('amount' => 'xsd:int', 'rate' => 'xsd:float'),      // parameter (required)
    array('return' => 'xsd:string'),                          // output (required)
    $namespace,                                               // namespace
    $namespace.'#currencyConverter',                          // soapaction
    'rpc',                                                    // style
    'encoded',                                                // use
    'Convert amount in USD to ZAR using the rate'             // description
);

function convertCurrency($amount, $rate)
{
    $total = ($amount*$rate);
    return number_format($total, 2);
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit;
