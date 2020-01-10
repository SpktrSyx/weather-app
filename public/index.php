<?php

use App\Controller\WeatherController;
use App\Service\WeatherService;

require './../vendor/autoload.php';

$controller = new WeatherController();
if (count($_POST) > 0) {
    $controller->showByCity();
} else {
    $controller->show();
}





