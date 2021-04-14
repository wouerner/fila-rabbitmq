<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

final class Rabbitmq
{
    private const RABBITMQ_HOST = 'rabbitmq';
    private const RABBITMQ_PORT = 5672;
    private const RABBITMQ_USER = 'guest';
    private const RABBITMQ_PASS = 'guest';
    private const TIME_WAIT = 2;
    private $con = null;

    public function __construct($data)
    {
        $this->connect();
        $this->config();
        $this->message($data);
        $this->close();
    }

    final private function connect()
    {
        while (1) {
            try {
                $this->con = new AMQPStreamConnection(RABBITMQ_HOST, RABBITMQ_PORT, RABBITMQ_USER, RABBITMQ_PASS);
                break;
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                sleep(TIME_WAIT);
                continue;
            }
        }
    }

    final private function config()
    {
        $this->channel = $this->con->channel();

        $this->channel->exchange_declare('pedido_exchange', 'fanout', false, $durable = true, false);
    }

    final private function message($data)
    {
        $msg = new AMQPMessage(
            $data,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        foreach (range(0, 1000000) as $i) {
            $this->channel->basic_publish($msg, 'pedido_exchange');
        }
    }

    final private function close()
    {
        $this->channel->close();
        $this->con->close();
    }
}
