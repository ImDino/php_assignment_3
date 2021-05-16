<?php
session_start();

require_once ("models/Database.php");
require_once ("models/Model.php");
require_once ("views/View.php");
require_once ("controllers/Controller.php");

$database   = new Database('uppgift', 'admin', 'nackademin', 'php-assignment-3.cpxa3ccuhmpt.eu-west-1.rds.amazonaws.com');
$model      = new Model($database);
$view       = new View();
$controller = new Controller($model, $view);

$controller->main();