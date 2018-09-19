<?php

namespace Dna\RabbitMq\Contracts\Basic;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AbstractConnection;
use Dna\RabbitMq\Contracts\Client;

/**
 * Basic Sender Contracts
 * 
 * You should implement
 * 
 * - initConnection() 
 * - declareExchange();
 * - declareQueue(); 
 * - close();
 */
abstract class Sender extends Client
{
    protected $req_queue_name = 'basic';
    protected $exchange_name  = null;

    /**
     * Publish Message
     *
     * @param AMQPMessage $msg
     * @param string $routing_key
     * @param boolean $mandatory
     * @param boolean $immediate
     * @param integer $ticket
     * @return void
     */
    public function publish(
        AMQPMessage $msg,
        string $routing_key = null,
        bool $mandatory = false,
        bool $immediate = false,
        int $ticket = null
    ){

        $routing_key = $routing_key?$routing_key:$this->req_queue_name;
        
        $this->channel->basic_publish(
            $msg,
            '',
            $routing_key,
            $mandatory,
            $immediate,
            $ticket
        );
    }
}