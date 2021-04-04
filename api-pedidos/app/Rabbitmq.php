<?php
namespace App;

class Rabbitmq {

    public function __construct(){
        include __DIR__ . '/../send.php';
    }
}
