<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SERVER_ROOT ?>/styles/style.css?ver=<?php echo time() ?>">

    <title><?php echo $title ?> - PHP Butiken</title>
</head>

<?php

$email = $_SESSION['email'] ?? null;
$isAdmin = $_SESSION['isAdmin'] ?? null;
$serverRoot = SERVER_ROOT;

?>

<nav class="navbar navbar-expand-lg navbar-light bg-light d-flex justify-content-between">
    <a class="navbar-brand" href="<?php echo SERVER_ROOT ?>">PHP Butiken</a>   
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav justify-content-between">
        <a class="nav-link mr-1" href="<?php echo SERVER_ROOT ?>/cart">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="#000000" class="bi bi-cart4" viewBox="0 0 16 16">
                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
                    </svg>
                </a>
            <?php
            if ($isAdmin) {
                echo "<li class='nav-item'>
                        <a class='nav-link' href='$serverRoot/admin'>Admin</a>
                    </li>";
            }
            ?>
            <?php

            echo !$email
                ?
                "<li class='nav-item'>
                    <a class='nav-link' href='$serverRoot/user/login'>Logga in</a>
                </li>"
                :
                "<li class='nav-item'>
                    <a class='nav-link' href='$serverRoot/user/logout'>Logga ut ($email)</a>
                </li>";
            ?>
        </ul>
    </div>
</nav>

<body>
    <div class="d-flex flex-column align-items-center container">
        <div id="ghost-div"></div>
        <h2 class="text-center mt-4 mb-5"><?php echo $title ?></h2>