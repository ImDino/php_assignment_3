<?php
session_start();
define('SERVER_ROOT', str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));

// Models
require_once("models/Database.php");
require_once("models/Model.php");

// View
require_once("views/View.php");

// Controllers
require_once("controllers/AdminController.php");
require_once("controllers/Controller.php");
require_once("controllers/UserController.php");

//TODO update article är paj??
//TODO Fråga Mahmoud: rätt att ha som model istället, model såvitt jag vet används för att hantera db o sånt bara?
//TODO ta reda på hur vi ska rensa alla controllers så mycket som möjligt.
//TODO jämför hastighet när man deklarerar klassvariabler innan och kör main i switchen.

$database   = new Database('uppgift', 'admin', 'nackademin', 'php-assignment-3.cpxa3ccuhmpt.eu-west-1.rds.amazonaws.com');
$model      = new Model($database);
$view       = new View();

$url = explode('/', $_GET['url']);
$path = $url[0] ?? "";

switch ($path) {
    case "admin":
        new AdminController($model, $view);
        break;
    case "user":
        new UserController($model, $view);
        break;
    default:
        new Controller($model, $view);
}