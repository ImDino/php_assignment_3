<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="styles/style.css?ver=<?php echo rand(111,999)?>">
    <title><?php echo $title; ?> - PHP Butiken</title>
</head>

<script>

const urlParams = new URLSearchParams(window.location.search);
const page = urlParams.get('page');

$(document).ready(function(){
    $(document).on('input', function(e){
        const field = e.target;
        validate(field);
        
        if (field.hasAttribute('required')) {
        }
    })

})

function validate(field) {
    $.ajax({
        //url:"Controllers/Ajax.php",    //the page containing php script
        url: "Controllers/Ajax.php/test",
        type: "get",    //request type,
        //data: {field: JSON.stringify({name: field.name, value: field.value})},
        success:function(result){
            console.log(result);
        }
    });
}
</script>

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
