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
require_once("controllers/CartController.php");
require_once("controllers/ProductController.php");
require_once("controllers/UserController.php");


/*
TODO cartController - klassvariabel för total - createCart - addToCart - placeOrder m.m.
NOTE Model är bara för DB, ha checkMsg i en separat utils-fil.

TODO dela upp metoder i controllers om möjligt, seperation of concerns är mottot.
TODO sätt absolut path på allt, även form actions (med hjälp av SERVER_ROOT konstanten).
TODO jämför nuvarande hastighet mot att deklarera alla klassobjekt och kör main i switchen ist.
*/


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
    case "cart":
        new CartController($model, $view);
        break;
    default:
        new ProductController($model, $view);
}