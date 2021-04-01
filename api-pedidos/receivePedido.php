<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('pedido_exchange', 'direct', false, $durable = true, false);

/**
 * Declara qual a fila que será usada
 */
/* $channel->queue_declare('pedido', false, false, false, false); */
$channel->queue_declare("pedido_queue", false, true, false,  false);
$channel->queue_bind("pedido_queue", 'pedido_exchange', 'pedido_queue');

echo ' [*] Esperando pedidos. To exit press CTRL+C', "\n";

/**
 * Função que vai receber e tratar efetivamente a mensagem
 */
$callback = function($msg) {
  echo date('m/d/Y h:i:s a', time()) . " [x] Received ", $msg->body, "\n";
};

/**
 * Adiciona esse "callback" para a fila 
 */
$channel->basic_consume('pedido_queue', '', false, true, false, false, $callback);

/**
 * Mantem a função escutando a fila por tempo indeterminado, até que seja encerrada
 */
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
