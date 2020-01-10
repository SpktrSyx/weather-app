<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\WeatherForm;
use App\Service\WeatherService;

class WeatherController
{


    public function __construct()
    {

    }


    public function showByCity()
    {
        try {
            $city = new City();
            $city->setCity($_POST['city']);
            $city2 = $city->getCity();
            $form = new WeatherForm();
            if ($form->verify($city) == true) {
                $weather = new WeatherService();
                $response = $weather->getByCity($city2);
                include __DIR__ . '/../../View/defaultView.php';
            }

        } catch (\DomainException $exception) {
            $message = "le service n'est pas disponible. Contactez l'administrateur!";
            include __DIR__ . '/../../View/defaultView.php';
        } catch (\InvalidArgumentException $exception) {
            $message = "la ville : \"" . $_POST["city"] . "\" n'a pas été retrouvée";
            include __DIR__ . '/../../View/defaultView.php';
        } catch (\TypeError $exception) {
            $message = "Veuillez remplir le champ";
            include __DIR__ . '/../../View/defaultView.php';
        }
    }

    public function show()
    {
        try{
            $weather = new WeatherService();
            $response = $weather->getGeoLoc();
            include __DIR__ . '/../../View/defaultView.php';
        } catch (\DomainException $exception) {
            $message = "le service n'est pas disponible. Contactez l'administrateur!";
            include __DIR__ . '/../../View/defaultView.php';
        }

    }
}
