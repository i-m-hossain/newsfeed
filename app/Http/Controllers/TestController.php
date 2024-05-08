<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use \App\Service\Contracts\TestInterface;
class TestController extends Controller
{
    public function __construct(private TestInterface $testService){

    }
    public function logData(){
        $message = $this->testService->logData();
        return $message;
    }

}
