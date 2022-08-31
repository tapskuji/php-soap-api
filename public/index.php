<?php

require_once __DIR__ . '/../config/bootstrap.php';

$title = 'SOAP API Tutorial';

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

        th, td {
            padding: 4px;
        }
    </style>
    <title><?php echo safe_html($title); ?></title>
</head>
<body>
<header>
    <h1>SOAP Tutorials</h1>
</header>
<main>
    <div id="content">
        <p>This is a tutorial on how to create a SOAP API using NuSOAP and consume a SOAP API using NuSOAP</p>
        <div class="tutorial listing">

            <table class="list">
                <tr>
                    <th>Number</th>
                    <th>Tutorial</th>
                    <th>&nbsp;</th>
                </tr>

                <?php foreach ($tutorials as $index => $tutorial) { ?>
                    <tr>
                        <td><?php echo safe_html($index); ?></td>
                        <td><?php echo safe_html($tutorial['name']); ?></td>
                        <td><a class="action" href="<?php echo url_for($tutorial['url']); ?>">View</a></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</main>
<footer></footer>
</body>
</html>