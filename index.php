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

// Utils
require_once("utils/Message.php");

$database   = new Database('uppgift', 'admin', 'nackademin', 'php-assignment-3.cpxa3ccuhmpt.eu-west-1.rds.amazonaws.com');
$model      = new Model($database);
$view       = new View();

$path = explode('/', $_GET['url'])[0];

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

Message::check();

/*
TODO större header

TODO ikoner
TODO fixa centrering utan att ensam artikel längst ner är i mitten.
TODO email och logga in/ut i headern till höger
TODO Fixa max bredden på former

NOTE mina todos tar jag om det finns tid för det, vi börjar väl med mer övergripande struktur
TODO (Dino) fixa ikoner för knappar (t ex penna för redigera)
TODO (Dino) kundkorg som visar en liten siffra 
TODO (Dino) göra så sidan minns scroll position

*/