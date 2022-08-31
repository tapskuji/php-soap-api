<?php

require_once __DIR__ . '/../../config/bootstrap.php';

//Create a new soap server
$server = new soap_server();

//Configure our WSDL
$serviceName = "TaskWebService";
$server->configureWSDL($serviceName);

//Define our namespace
$namespace = "http://localhost/soap/TaskWebService";
$server->wsdl->schemaTargetNamespace = $namespace;

$server->soap_defencoding = "utf-8";

//Create a complex type
$server->wsdl->addComplexType(
    'TaskInput',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'title' => array('name' => 'title', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'description' => array('name' => 'description', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'deadline' => array('name' => 'deadline', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'isComplete' => array('name' => 'isComplete', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:boolean'),
    )
);

//Create a complex type
$server->wsdl->addComplexType(
    'Task',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:int'),
        'title' => array('name' => 'title', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'description' => array('name' => 'description', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'deadline' => array('name' => 'deadline', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'isComplete' => array('name' => 'isComplete', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:boolean'),
    )
);

//Create a complex type
$server->wsdl->addComplexType(
    'TaskArray',
    'complexType',
    'array',
    'all',
    'SOAP-ENC:Array',
    array(),
    array(array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Task[]')),
    'tns:Task'
);

//Register our method using the complex type
$server->register(
    'addTask',	                                 // method name:
    array('task'=>'tns:TaskInput'),	             // parameter list:
    array('return'=>'tns:TaskArray'), 	         // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       // 'encoded', // use: encoded or literal
    'Add a new task'                             // description
);

/* method returns the defined complex type (associative array) */
function addTask($task)
{
    //error_log(print_r($task, 1), 0);
    $tasks = array(
        array('id' => 1, 'title' => 'Clean House', 'description' => 'Sweep and mop floors', 'deadline' => '2022-07-31', 'isComplete' => true),
        array('id' => 2, 'title' => 'Wash car', 'description' => 'Clean car exterior', 'deadline' => '2022-08-29', 'isComplete' => true),
    );
    $newTask['id'] = count($tasks) + 1;
    $newTask['title'] = $task['title'];
    $newTask['description'] = $task['description'];
    $newTask['deadline'] = $task['deadline'];
    $newTask['isComplete'] = array_key_exists('isComplete', $task) ? $task['isComplete'] : false;
    $tasks[] = $newTask;
    return $tasks;
}

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit;