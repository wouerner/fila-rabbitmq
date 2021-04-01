<?php
require_once __DIR__ . '/vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/app/Pedido.php';
        new App\Pedido();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
