<?php
session_start();
include_once('resources.php')
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
            <?php echo '<a href="'. GOOGLE_API .'?scope='. SCOPE . '&redirect_uri=' . URI . '&response_type=code&client_id=' . CLIENT_ID .'"><button class="btn btn-lg btn-danger">Google+</button></a>'; ?>
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
