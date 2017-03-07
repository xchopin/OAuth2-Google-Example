<?php
session_start();
include_once('resources.php');

$refresh = true;
if (isset($_SESSION['currentDate'])) {
    $refresh = false;
    $testDate = (new DateTime())->getTimestamp();
    if ($testDate - $_SESSION['currentDate'] >= $_SESSION['expiresIn'])
        $refresh = true;
}
// If the user doesn't have a token or if it expired we create another one
if ($refresh) {
    $url = 'https://www.googleapis.com/oauth2/v4/token';
    $data = array(
        'code' => $_GET['code'],
        'client_id' =>  CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'redirect_uri' => URI,
        'grant_type' => 'authorization_code'
    );
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $json = json_decode(file_get_contents($url, false, $context));
    if ($json === FALSE) {
        echo 'Error, token expired; please log again';
        return;
    }

    $_SESSION['accessToken'] = $json->access_token;
    $_SESSION['currentDate'] = (new DateTime())->getTimestamp();
    $_SESSION['expiresIn'] = $json->expires_in;
    $_SESSION['refreshToken'] = $json->refresh_token;
}

$urlCalendar = 'https://www.googleapis.com/calendar/v3/calendars/primary/events?access_token=' . $_SESSION['accessToken'];

$dataToSend = [
    'start' => ['date' => '2017-03-09'],
    'end' => ['date' => '2017-03-31'],
    'summary' => 'A random event'
];

$options = array(
    'http' => array(
        'header'  => "Content-type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($dataToSend)
    )
);
$context  = stream_context_create($options);
file_get_contents($urlCalendar, false, $context);
$events = json_decode(file_get_contents($urlCalendar))->items;
//header('Content-Type: application/json');
//var_dump($events);
?>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>OAuth2 Example</title>
    <link href="https://blackrockdigital.github.io/startbootstrap-bare/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {  padding-top: 70px;  }
    </style>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">OAuth2 Example</a>
        </div>
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">

    <div class="row">
        <div class="col-lg-12 text-center">
          <button class="btn btn-success"> Your event has been created ! </button> <br>
            <h3>My events :</h3>
            <ul class="list-group">
                <?php
                    foreach($events as $event) {
                        echo '<li class="list-group-item"><b>' . $event->summary . '</b>';
                        // Some events do not have a period
                        if (property_exists($event,'start')){
                            if (property_exists($event->start,'date'))
                                echo '<span class="badge">' . $event->start->date . ' - ' . $event->end->date . '</span>';
                        }
                        echo '</li><hr>';
                    }
                ?>
            </ul>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- jQuery Version 1.11.1 -->
<script src="https://blackrockdigital.github.io/startbootstrap-bare/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="https://blackrockdigital.github.io/startbootstrap-bare/js/bootstrap.min.js"></script>




</body></html>