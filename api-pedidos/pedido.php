<?php

require_once __DIR__ . '/vendor/autoload.php';

$rabbitmq = new App\Rabbitmq;

var_dump($_POST);
$produto = $_POST['produto'];

echo "salvando banco de dados";
$produto = ['id' => rand(), 'produto' => $produto];

$produto = json_encode($produto);

// rabbit
include 'send.php';
