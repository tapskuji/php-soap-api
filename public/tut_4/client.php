<?php

require_once __DIR__ . '/../../config/bootstrap.php';

// This is your Web service server WSDL URL address
$wsdl = "http://localhost/tut_4/server.php?wsdl";

// Create client object
$client = new nusoap_client($wsdl, 'wsdl');
$err = $client->getError();

if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

$operation = 'getCountries';
$message = array('continent' => 'africa');
$response = $client->call($operation, $message);

$err = $client->getError();
if ($err) {
    die('<h2>Constructor error</h2>' . $err);
}

$countries = join(', ', $response);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php safe_html($tutorials[4]['name']); ?></title>
</head>
<body>
<header>
    <h1><?php safe_html($tutorials[4]['name']); ?></h1>
</header>
<main>
    <div class="container">
        <a class="back-link" href="<?php echo url_for('/index.php'); ?>">&laquo; Back to List</a>
        <br/>
        <br/>
        <a class="back-link" href="<?php echo url_for($tutorials[4]['wsdl_location']); ?>" target="_blank">View WSDL(machine readable)</a>
        <br/>
        <br/>
        <a class="back-link" href="<?php echo url_for($tutorials[4]['wsdl']); ?>" target="_blank">View WSDL</a>
        <br/>
        <br/>
        Operation: <?php echo htmlspecialchars($operation); ?>
        <br />
        Params: <?php echo htmlspecialchars(empty($message) ? '' : print_r($message, 1)); ?>
        <br />
        Response: <?php echo htmlspecialchars($countries); ?>
    </div>
</main>
<footer></footer>
</body>
</html>