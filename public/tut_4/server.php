<?php

require_once __DIR__ . '/../../config/bootstrap.php';

//Create a new soap server
$server = new soap_server();

//Configure our WSDL
$serviceName = "CountyService";
$server->configureWSDL($serviceName);

//Define our namespace
$namespace = "http://localhost/soap/CountyService";
$server->wsdl->schemaTargetNamespace = $namespace;

//Create a complex type
$server->wsdl->addComplexType(
    'countries',
    'complexType',
    'array',
    'all',
    'SOAP-ENC:Array',
    array(),
    array(array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType'=>'xsd:string[]')),
    'xsd:string'
);

/* Register our method using the complex type */
$server->register(
    'getCountries',                                // method name:
    array('continent' => 'xsd:string'),            // parameter list:
    array('return' => 'tns:countries'),            // return value(s):
    $namespace,                                    // namespace:
    false,                                         // soapaction: (use default)
    'rpc',                                         // style: rpc or document
    false,                                         // use: encoded or literal, default is 'encoded',
    'Get names of counties on a given continent'   // description
);

/* method return the defined complex type (array of strings) */
function getCountries($continent)
{
    $continent = strtolower($continent);

    if ($continent == 'africa')
        return array('South Africa', 'Zimbabwe', 'Zambia', 'Namibia');
    elseif ($continent == 'europe')
        return array('Belgium', 'UK', 'France', 'Germany');
    elseif ($continent == 'asia')
        return array('Japan', 'India', 'China');
    return array();
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit();
