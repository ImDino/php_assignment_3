<?php

session_start();
define('SERVER_ROOT', str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));

//Utils
require_once("utils/DotEnv.php");
use DevCoder\DotEnv;
(new DotEnv(__DIR__ . '/.env'))->load();

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

$database   = new Database(getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASS'), getenv('DB_HOST'));
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