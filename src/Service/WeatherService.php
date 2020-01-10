<?php

namespace App\Service;

use App\Entity\Weather;
use http\Exception\InvalidArgumentException;

class WeatherService
{

    public function getByCity(string $city)
    {

        $contents = @file_get_contents('http://api.openweathermap.org/data/2.5/weather?q=' . $city . ',fr&APPID=549f708df3e97234deb5a24296a9e9dc');
        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = (int)$match[1];
        if (!isset($http_response_header[0])) {
            throw new \DomainException();
        }
        if ($contents === false) {
            throw new \InvalidArgumentException();
        }
        if (200 === $status) {
            $body = json_decode($contents);
            $weatherModel = new Weather();
            $weatherModel->setCity($body->name);
            $weatherModel->setDescription($body->weather[0]->description);
            $weatherModel->setIcon($body->weather[0]->icon);
            $weatherModel->setTemperature($body->main->temp - 273.15);
            return $weatherModel;
        }

    }

    public function getGeoLoc()
    {
        $ip = json_decode(@file_get_contents('http://edns.ip-api.com/json'));
        $coordonnees = json_decode(@file_get_contents('http://ip-api.com/json/' . $ip->dns->ip));
        $contents = @file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat=' . $coordonnees->lat . '&lon=' . $coordonnees->lon . '&APPID=549f708df3e97234deb5a24296a9e9dc');
        $status_line = $http_response_header[0];
        preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
        $status = (int)$match[1];
        if (!isset($http_response_header[0])) {
            throw new \DomainException();
        }
        if ($status == 200) {
            $body = json_decode($contents);
            $weatherModel = new Weather();
            $weatherModel->setCity($body->name);
            $weatherModel->setDescription($body->weather[0]->description);
            $weatherModel->setIcon($body->weather[0]->icon);
            $weatherModel->setTemperature($body->main->temp - 273.15);
            return $weatherModel;
        }
    }


}