<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('pedido_exchange', 'fanout', false, $durable = true, false);

/**
 * Declara qual a fila que será usada
 */
/* $channel->queue_declare('pedido', false, false, false, false); */

/**
 * Cria a nova mensagem
 */
$msg = new AMQPMessage(
    $produto, 
    ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
);

/**
 * Envia para a fila
 */
foreach(range(0,1000000) as $i) {
    $channel->basic_publish($msg, 'pedido_exchange');
}

/**
 * Encerra conexão
 */
$channel->close();
$connection->close();

