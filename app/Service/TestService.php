<?php
namespace App\Service;
use App\Service\Contracts\TestInterface;

class TestService implements TestInterface{
    public function logData():string
    {
        return "messaged logged from a service class";
    }
}
