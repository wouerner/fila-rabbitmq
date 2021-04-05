<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbitmq {

    public function __construct($data) {
        /**
         * Inicia a conexão
         */
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');

        $channel = $connection->channel();

        $channel->exchange_declare('pedido_exchange', 'fanout', false, $durable = true, false);

        /**
         * Cria a nova mensagem
         */
        $msg = new AMQPMessage(
            $data, 
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
    }
}
