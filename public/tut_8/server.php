<?php

require_once __DIR__ . '/../../config/bootstrap.php';
require_once __DIR__ . '/operations.php';
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
    'Subtask',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:int'),
        'task_id' => array('name' => 'task_id', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:int'),
        'title' => array('name' => 'title', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'description' => array('name' => 'description', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'deadline' => array('name' => 'email', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'isComplete' => array('name' => 'isComplete', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:boolean'),
    )
);

//Create a complex type
$server->wsdl->addComplexType(
    'SubtaskArray',
    'complexType',
    'array',
    'all',
    'SOAP-ENC:Array',
    array(),
    array(array('ref'=>'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:Subtask[]')),
    'tns:Subtask'
);

//Create a complex type
$server->wsdl->addComplexType(
    'Task',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'id' => array('name' => 'id', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:int'),
        'title' => array('name' => 'title', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'description' => array('name' => 'description', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'deadline' => array('name' => 'deadline', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string'),
        'isComplete' => array('name' => 'isComplete', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'xsd:boolean'),
        'subtasks' => array('name' => 'subtasks', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'tns:SubtaskArray')
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

// ResponseArray
//Create a complex type
$server->wsdl->addComplexType(
    'TaskResponseArray',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'status' => array('name' => 'status', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'message' => array('name' => 'message', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'results' => array('name' => 'results', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'tns:TaskArray')
    )
);

$server->wsdl->addComplexType(
    'SubtaskResponseArray',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'status' => array('name' => 'status', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'message' => array('name' => 'message', 'minOccurs' => '1', 'maxOccurs' => '1', 'type' => 'xsd:string', 'annotation' => array('name' => 'documentation')),
        'results' => array('name' => 'results', 'minOccurs' => '0', 'maxOccurs' => '1', 'type' => 'tns:SubtaskArray')
    )
);

/* Register our methods */
$server->register(
    'createTask',	                             // method name:
    array('task' => 'tns:Task'),	             // parameter list:
    array('return' => 'tns:TaskResponseArray'),  // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       //'encoded', // use: encoded or literal
    'Add a new task'                             // description
);

$server->register(
    'getTask',                                   // method name:
    array('id' => 'xsd:int'),	                 // parameter list:
    array('return' => 'tns:TaskResponseArray'),  // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       //'encoded', // use: encoded or literal
    'Get a task using task id'                   // description
);

$server->register(
    'getTasks',                                  // method name:
    array(),                	                 // parameter list:
    array('return' => 'tns:TaskResponseArray'),  // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       //'encoded', // use: encoded or literal
    'Get all tasks'                              // description
);

$server->register(
    'updateTask',                                // method name:
    array('task' => 'tns:Task'),	             // parameter list:
    array('return' => 'tns:TaskResponseArray'),  // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       //'encoded', // use: encoded or literal
    'Get a task using task id'                   // description
);

$server->register(
    'deleteTask',                                // method name:
    array('id' => 'xsd:int'),	                 // parameter list:
    array('return' => 'tns:TaskResponseArray'),  // return value(s):
    $namespace, 	                             // namespace:
    false,	                                     // soapaction: (use default)
    'rpc',	                                     // style: rpc or document
    false,                                       //'encoded', // use: encoded or literal
    'Delete a task using task id'                // description
);

$server->register(
    'createSubtask',	                             // method name:
    array('subtask' => 'tns:Subtask'),	             // parameter list:
    array('return' => 'tns:SubtaskResponseArray'), 	 // return value(s):
    $namespace, 	                                 // namespace:
    false,	                                         // soapaction: (use default)
    'rpc',	                                         // style: rpc or document
    false,                                           //'encoded', // use: encoded or literal
    'Add a subtask to a task'                        // description
);

$server->register(
    'updateSubtask',	                             // method name:
    array('subtask' => 'tns:Subtask'),	             // parameter list:
    array('return' => 'tns:SubtaskResponseArray'), 	 // return value(s):
    $namespace, 	                                 // namespace:
    false,	                                         // soapaction: (use default)
    'rpc',	                                         // style: rpc or document
    false,                                           //'encoded', // use: encoded or literal
    'Update a subtask'                               // description
);

$server->register(
    'getSubtask',	                                   // method name:
    array('id' => 'xsd:int', 'task_id' => 'xsd:int'),  // parameter list:
    array('return' => 'tns:SubtaskResponseArray'), 	   // return value(s):
    $namespace, 	                                   // namespace:
    false,	                                           // soapaction: (use default)
    'rpc',	                                           // style: rpc or document
    false,                                             //'encoded', // use: encoded or literal
    'Get a subtask'                                    // description
);

$server->register(
    'getSubtasks',	                                   // method name:
    array('task_id' => 'xsd:int'),                     // parameter list:
    array('return' => 'tns:SubtaskResponseArray'), 	   // return value(s):
    $namespace, 	                                   // namespace:
    false,	                                           // soapaction: (use default)
    'rpc',	                                           // style: rpc or document
    false,                                             //'encoded', // use: encoded or literal
    'Get all subtasks for a task'                      // description
);

$server->register(
    'deleteSubtask',	                               // method name:
    array('id' => 'xsd:int', 'task_id' => 'xsd:int'),  // parameter list:
    array('return' => 'tns:SubtaskResponseArray'), 	   // return value(s):
    $namespace, 	                                   // namespace:
    false,	                                           // soapaction: (use default)
    'rpc',	                                           // style: rpc or document
    false,                                             //'encoded', // use: encoded or literal
    'Delete a subtask'                                 // description
);

// Get our posted data if the service is being consumed
// otherwise leave this data blank.
$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';

// pass our posted data (or nothing) to the soap service
$server->service($POST_DATA);
exit();

