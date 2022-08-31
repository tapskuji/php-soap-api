<?php

require_once __DIR__ . '/../../config/bootstrap.php';

// This is your Web service server WSDL URL address
$wsdl = "http://localhost/tut_8/server.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$client->soap_defencoding = 'utf-8';
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

$operation = 'getTasks';
$message = array();
$response = $client->call($operation, $message);
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

if ($response['status'] !== 'success') {
    exit($response['message']);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <title><?php safe_html($tutorials[8]['name'])?></title>
</head>
<body>
<header>
    <h1><?php safe_html($tutorials[8]['name'])?></h1>
</header>
<main>
    <div class="container">
        <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>
        <br/>
        <br/>
        <a class="back-link" href="<?php echo url_for($tutorials[8]['wsdl_location']); ?>" target="_blank">View WSDL(machine readable)</a>
        <br/>
        <br/>
        <a class="back-link" href="<?php echo url_for($tutorials[8]['wsdl']); ?>" target="_blank">View WSDL</a>
        <br/>
        <br/>
        <div class="actions">
            <a class="action" href="<?php echo url_for('/tut_8/add.php'); ?>">Create New Task</a>
        </div>
        <p>List of tasks</p>
        <br/>
        <div class="task listing">

            <table class="list">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Deadline</th>
                    <th>Total Subtasks</th>
                    <th>Complete</th>
                    <th> </th>
                    <th> </th>
                </tr>

                <?php foreach ($response['results'] as $index => $task) { ?>
                    <tr>
                        <td><?php echo safe_html($task['id']); ?></td>
                        <td><?php echo safe_html($task['title']); ?></td>
                        <td><?php echo safe_html($task['description']); ?></td>
                        <td><?php echo safe_html($task['deadline']); ?></td>
                        <td><?php echo count($task['subtasks']); ?></td>
                        <td><?php echo ($task['isComplete'] ? 'true' : 'false'); ?></td>
                        <td><a class="action" href="<?php echo url_for('/tut_8/view.php?id=' . safe_html(urlencode($task['id']))); ?>">View</a></td>
                        <td><a class="action" href="<?php echo url_for('/tut_8/edit.php?id=' . safe_html(urlencode($task['id']))); ?>">Edit</a></td>
                        <td><a class="action" href="<?php echo url_for('/tut_8/delete.php?id=' . safe_html(urlencode($task['id']))); ?>">Delete</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<footer></footer>
</body>
</html>