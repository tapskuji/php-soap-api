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

//Create a complex type
$server->wsdl->addComplexType(
    'StudentComplexType',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'contact' => array('name' => 'contact','type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'email' => array('name' => 'email','type' => 'xsd:string'),
        'id' => array('name' => 'id','type' => 'xsd:int'),
    )
);

/* Register our method using the complex type */
$server->register(
    'getStudentById',                            // method name:
    array('id'=>'xsd:int'),                      // parameter list:
    array('return'=>'tns:StudentComplexType'),   // return value(s):
    $namespace,                                  // namespace:
    false,                                       // soapaction: (use default)
    'rpc',                                       // style: rpc or document
    false,                                       // use: encoded or literal, default is 'encoded',
    'Get a students details using student id'    // description
);

/* method returns the defined complex type (associative array) */
function getStudentById($id)
{
    $students = array(
        array(
            'contact' => 'John',
            'email' => 'john_doe@gmail.com',
            'id' => 1
        ),
        array(
            'contact' => 'Alice',
            'email' => 'alice@gmail.com',
            'id' => 2
        ),
    );
    return array_key_exists($id, $students) ? $students[$id] : array();
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit;