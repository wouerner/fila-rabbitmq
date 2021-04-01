<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->exchange_declare('pedido_exchange', 'direct', false, $durable = true, false);

$channel->queue_declare("pedido_queue", false, $durable = true, false, false);

$channel->queue_bind("pedido_queue", 'pedido_exchange', 'pedido_queue');

/**
 * Declara qual a fila que será usada
 */
/* $channel->queue_declare('pedido', false, false, false, false); */

/**
 * Cria a nova mensagem
 */
$msg = new AMQPMessage($produto, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));

/**
 * Envia para a fila
 */
foreach(range(0,1000000) as $i) {
    $channel->basic_publish($msg, 'pedido_exchange', 'pedido_queue');
}

/**
 * Encerra conexão
 */
$channel->close();
$connection->close();

