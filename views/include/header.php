<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo SERVER_ROOT?>/styles/style.css?ver=<?php echo time()?>">

    <title><?php echo $title; ?> - PHP Butiken</title>
</head>

<?php
$email = $_SESSION['email'] ?? null;
$isAdmin = $_SESSION['isAdmin'] ?? null;
$serverRoot = SERVER_ROOT;
?>

<body class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="<?php echo SERVER_ROOT?>/">PHP Butiken</a>
        <?php
        echo $email ? $email : '';
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php 

                echo !$email 
                    ?
                    "<li class='nav-item'>
                        <a class='nav-link' href='$serverRoot/user/login'>Logga in</a>
                    </li>"
                    :
                    "<li class='nav-item'>
                        <a class='nav-link' href='$serverRoot/user/logout'>Logga ut</a>
                    </li>";
                ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SERVER_ROOT?>/checkout">Kundkorg</a>
                </li>

                <?php
                if ($isAdmin) {
                    echo "<li class='nav-item'>
                            <a class='nav-link' href='admin'>Admin</a>
                        </li>";
                }
                ?>
            </ul>
        </div>
    </nav>
    <h2 class="text-center"><?php echo $title; ?></h2>
    <div class="row">
