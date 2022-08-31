<?php

require_once __DIR__ . '/../../config/bootstrap.php';

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

$operation = 'getTask';
$message = array('id' => $id);
$response = $client->call($operation, $message);
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

if ($response['status'] !== 'success') {
    exit($response['message']);
}

$task = $response['results'][0];
$subtasks = $task['subtasks'] ? $task['subtasks'] : array();

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
        <a class="back-link" href="<?php echo url_for('/tut_8/index.php'); ?>">&laquo; Back to List</a>
        <br/>
        <br/>
        <p>View task</p>
        <br/>

        <p><b>Task ID:</b> <?php echo safe_html($task['id']); ?></p>
        <p><b>Title:</b> <?php echo safe_html($task['title']); ?></p>
        <p><b>Description:</b> <?php echo safe_html($task['description']); ?></p>
        <p><b>Deadline:</b> <?php echo safe_html($task['deadline']); ?></p>
        <p><b>Subtasks:</b> <?php echo count($subtasks); ?></p>
        <p><b>Complete:</b> <?php echo ($task['isComplete'] ? 'true' : 'false'); ?></p>

        <div class="actions">
            <a class="action" href="<?php echo url_for('/tut_8/subtask/add.php?task_id=' . safe_html(urlencode($task['id']))); ?>">Create New Subtask</a>
        </div>

        <p>List of subtasks</p>
        <br/>

        <div class="task listing">

            <table class="list">
                <tr>
                    <th>ID</th>
                    <th>Task ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Deadline</th>
                    <th>Complete</th>
                    <th> </th>
                    <th> </th>
                </tr>

                <?php foreach ($subtasks as $index => $subtask) { ?>
                    <tr>
                        <td><?php echo safe_html($subtask['id']); ?></td>
                        <td><?php echo safe_html($subtask['task_id']); ?></td>
                        <td><?php echo safe_html($subtask['title']); ?></td>
                        <td><?php echo safe_html($subtask['description']); ?></td>
                        <td><?php echo safe_html($subtask['deadline']); ?></td>
                        <td><?php echo ($subtask['isComplete'] ? 'true' : 'false'); ?></td>
                        <?php $urlParams = "task_id=" . urlencode($subtask['task_id']) . "&id=" . urlencode($subtask['id']); ?>
                        <td><a class="action" href="<?php echo url_for('/tut_8/subtask/view.php?' . safe_html($urlParams)); ?>">View</a></td>
                        <td><a class="action" href="<?php echo url_for('/tut_8/subtask/edit.php?' . safe_html($urlParams)); ?>">Edit</a></td>
                        <td><a class="action" href="<?php echo url_for('/tut_8/subtask/delete.php?' . safe_html($urlParams)); ?>">Delete</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<footer></footer>
</body>
</html>