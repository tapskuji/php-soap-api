<?php

require_once __DIR__ . '/../../config/bootstrap.php';

//Create a new soap server
$server = new soap_server();

//Configure our WSDL
$serviceName = "StudentService";
$server->configureWSDL($serviceName);

//Define our namespace
$namespace = "http://localhost/soap/StudentService";
$server->wsdl->schemaTargetNamespace = $namespace;

$server->soap_defencoding = "utf-8";

//Create a complex type
$server->wsdl->addComplexType(
    'StudentComplexType',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'contact' => array('name' => 'contact', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'email' => array('name' => 'email', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'id' => array('name' => 'id', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:int'),
    )
);

//Register our method using the complex type
$server->register(
    'createStudent',	                         // method name:
    array('student'=>'tns:StudentComplexType'),	 // parameter list:
    array('return'=>'tns:StudentComplexType'), 	 // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       // use: encoded or literal, default is 'encoded',
    'Create a student'                           // description
);

/* method returns the defined complex type (associative array) */
function createStudent($student)
{
    /* log the input or any errors */
    // error_log(print_r($student, 1), 0);
    $result = array(
        'contact' => $student['contact'],
        'email' => strtolower($student['email']),
        'id' => rand(0, 100) // str_pad($student['id'], 7, '0', STR_PAD_RIGHT)
    );
    return $result;
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit;