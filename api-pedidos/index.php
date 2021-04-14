<?php
require_once __DIR__ . '/vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/store' :
        require __DIR__ . '/app/Pedido.php';
        $pedido = new App\Pedido();
        $pedido->store();
        break;
    case '/update' :
        require __DIR__ . '/app/Pedido.php';
        $pedido = new App\Pedido();
        $pedido->update();
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
