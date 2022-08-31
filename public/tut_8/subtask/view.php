<?php

require_once __DIR__ . '/../../../config/bootstrap.php';

$task_id = isset($_GET['task_id']) ? (int)$_GET['task_id'] : 1;
$id = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// This is your Web service server WSDL URL address
$wsdl = "http://localhost/tut_8/server.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$client->soap_defencoding = 'utf-8';
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

$operation = 'getSubtask';
$message = array('id' => $id, 'task_id' => $task_id);
$response = $client->call($operation, $message);
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

if ($response['status'] !== 'success') {
    exit($response['message']);
}

$subtask = $response['results'][0];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php safe_html($tutorials[8]['name'])?></title>
</head>
<body>
<header>
    <h1><?php safe_html($tutorials[8]['name'])?></h1>
</header>
<main>
    <div class="container">
        <a class="back-link" href="<?php echo url_for('/tut_8/view.php?id=' . safe_html(urlencode($task_id))); ?>">&laquo; Back to List</a>
        <br/>
        <br/>
        <p>View task</p>
        <br/>

        <p><b>Subtask ID:</b> <?php echo safe_html($subtask['id']); ?></p>
        <p><b>Title:</b> <?php echo safe_html($subtask['title']); ?></p>
        <p><b>Description:</b> <?php echo safe_html($subtask['description']); ?></p>
        <p><b>Deadline:</b> <?php echo safe_html($subtask['deadline']); ?></p>
        <p><b>Complete:</b> <?php echo ($subtask['isComplete'] ? 'true' : 'false'); ?></p>

    </div>
</main>
<footer></footer>
</body>
</html>