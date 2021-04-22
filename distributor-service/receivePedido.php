<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

/* const RB_HOST ='localhost'; */
const RB_HOST ='rabbitmq';
const RB_PORT ='5672';
const RB_USER ='guest';
const RB_PASS ='guest';

/**
 * Inicia a conexão
 */
while (1) {
    try {
        $connection = new AMQPStreamConnection(RB_HOST, RB_PORT, RB_USER, RB_PASS);
        break;
    } catch (\Exception $e) {
        var_dump($e->getMessage());
        sleep(2);
        continue;
    }
}

$channel = $connection->channel();

$channel->exchange_declare('pedido_exchange', 'fanout', false, $durable = true, false);

/**
 * Declara qual a fila que será usada
 */
$channel->queue_declare("distributor_queue", false, $durable = true, false, false);

$channel->queue_bind("distributor_queue", 'pedido_exchange');

echo ' [*] Esperando pedidos. To exit press CTRL+C', "\n";

/**
 * Função que vai receber e tratar efetivamente a mensagem
 */
$callback = function($msg) {
  echo date('m/d/Y h:i:s a', time()) . " [x] Validando Pagamento: ", $msg->body, "\n";

  $body = json_decode($msg->body);

  $pdo = new \PDO('sqlite:/app/db/pedidos.db');

  $sql = "UPDATE Pedidos set distributor = 1 where id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$body->id]);
};

/**
 * Adiciona esse "callback" para a fila 
 */
$channel->basic_consume('distributor_queue', '', false, true, false, false, $callback);

/**
 * Mantem a função escutando a fila por tempo indeterminado, até que seja encerrada
 */
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();
