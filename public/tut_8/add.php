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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operation = 'createTask';

    $task = array();
    $task['title'] = $_POST['title'] ? $_POST['title'] : '';
    $task['description'] = $_POST['description'] ? $_POST['description'] : '';
    $task['deadline'] = $_POST['deadline'] ? $_POST['deadline'] : '';
    $task['isComplete'] = $_POST['isComplete'] ? $_POST['isComplete'] : 0;

    $task['isComplete'] = (bool) $task['isComplete'];

    $message = array('task' => $task);
    $response = $client->call($operation, $message);
    $err = $client->getError();

    if ($err) {
        die('<h2>Constructor error</h2>' . $err);
    }

    if ($response['status'] !== 'success') {
        exit($response['message']);
    }

    redirect(url_for('/tut_8/index.php'));
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
        <a class="back-link" href="<?php echo url_for('/tut_8/index.php'); ?>">&laquo; Back to List</a>
        <br/>
        <br/>
        <p>Add task</p>
        <br/>

        <form action="<?php echo url_for('/tut_8/add.php'); ?>" method="post">
            <dl>
                <dt>Title:</dt>
                <dd><input type="text" name="title" value="" /></dd>
            </dl>
            <dl>
                <dt>Description:</dt>
                <dd><input type="text" name="description" value="" /></dd>
            </dl>
            <dl>
                <dt>Deadline:</dt>
                <dd><input type="text" name="deadline" value="" /></dd>
            </dl>
            <dl>
                <dt>Complete:</dt>
                <dd>
                    <input type="hidden" name="isComplete" value="0" />
                    <input type="checkbox" name="isComplete" value="1" />
                </dd>
            </dl>
            <div>
                <input type="submit" value="Save" />
            </div>
        </form>

    </div>
</main>
<footer></footer>
</body>
</html>