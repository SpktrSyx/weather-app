<?php


namespace App\Form;


use App\Entity\City;

class WeatherForm
{
    public function verify(City $city): bool
    {
        if ($city->getCity() != null) {
            $verif = preg_match('#^[a-zA-Zà-ýÀ-Ý\'-]{1,}$#', $city->getCity());
            if ($verif === 1) {
                return true;
            }
            return false;
        }
    }

    // /^[[:alpha:]]([-' ]?[[:alpha:]])*$/
}