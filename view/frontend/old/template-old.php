<!doctype html>
<html lang="en">
<head>
    <title><?= $titlePage ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300, 400,700|Inconsolata:400,700" rel="stylesheet">

    <link rel="stylesheet" href="public/css/bootstrap.css">
    <link rel="stylesheet" href="public/css/animate.css">
    <link rel="stylesheet" href="public/css/owl.carousel.min.css">

    <link rel="stylesheet" href="fonts/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="fonts/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <!-- Theme Style -->
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
<?php require('public/template/header.php'); ?>
<?php require('public/template/slides.html'); ?>


<?= $content ?>

<?php require('public/template/boxAbout.html'); ?>
<?php require('public/template/boxPopularPost.html'); ?>
<?php require('public/template/boxCategory.html'); ?>
<?php require('public/template/boxTag.html'); ?>
<?php require('public/template/endContent.html'); ?>

<?php require('public/template/footer.html'); ?>
</div>

<!-- loader -->
<div id="loader" class="show fullscreen">
    <svg class="circular" width="48px" height="48px">
        <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
        <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
                stroke="#f4b214"/>
    </svg>
</div>

<script src="public/js/jquery-3.2.1.min.js"></script>
<script src="public/js/jquery-migrate-3.0.0.js"></script>
<script src="public/js/popper.min.js"></script>
<script src="public/js/bootstrap.min.js"></script>
<script src="public/js/owl.carousel.min.js"></script>
<script src="public/js/jquery.waypoints.min.js"></script>
<script src="public/js/jquery.stellar.min.js"></script>


<script src="public/js/main.js"></script>
</body>
</html>