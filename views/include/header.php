<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - PHP Butiken</title>
    <link rel="stylesheet" href="styles/bootstrap.css">
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.php">PHP Butiken</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?page=login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=checkout">Kundkorg</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=admin">Admin</a>
                </li>
            </ul>
        </div>
    </nav>
    <h2 class="text-center"><?php echo $title; ?></h2>
    <div class="row">