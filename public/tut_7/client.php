<?php

require_once __DIR__ . '/../../config/bootstrap.php';

// This is your Web service server WSDL URL address
$wsdl = "http://localhost/tut_7/server.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

$operation = 'addTask';
$params = array('title'=> 'Learn Soap API', 'description' => 'Learn to create and consume a Soap Api', 'deadline' => '2022-08-05', 'isComplete' => false);
$message = array('task' => $params);
$response = $client->call($operation, $message);
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
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
    <title><?php safe_html($tutorials[7]['name'])?></title>
</head>
<body>
<header>
    <h1><?php safe_html($tutorials[7]['name'])?></h1>
</header>
<main>
    <div class="container">
        <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>
        <br/>
        <br/>
        <a class="back-link" href="<?php echo url_for($tutorials[7]['wsdl_location']); ?>" target="_blank">View WSDL(machine readable)</a>
        <br/>
        <br/>
        <a class="back-link" href="<?php echo url_for($tutorials[7]['wsdl']); ?>" target="_blank">View WSDL</a>
        <br/>
        <br/>
        Operation: <?php echo htmlspecialchars($operation)?>
        <br />
        Params: <?php echo htmlspecialchars(empty($message) ? '' : var_export($message, 1)); ?>
        <br />
        Response:
        <br />
        <div class="tutorial listing">

            <table class="list">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Deadline</th>
                    <th>Complete</th>
                </tr>

                <?php foreach ($response as $index => $task) { ?>
                    <tr>
                        <td><?php echo safe_html($task['id']); ?></td>
                        <td><?php echo safe_html($task['title']); ?></td>
                        <td><?php echo safe_html($task['description']); ?></td>
                        <td><?php echo safe_html($task['deadline']); ?></td>
                        <td><?php echo ($task['isComplete'] ? 'true' : 'false'); ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<footer></footer>
</body>
</html>