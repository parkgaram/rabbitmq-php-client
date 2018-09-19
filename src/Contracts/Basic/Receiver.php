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
abstract class Receiver extends Client
{
    protected $req_queue_name = 'basic';
    protected $exchange_name  = null;
    
    abstract protected function handle(AMQPMessage $msg);

    /**
     * @param bool $no_local
     * @param bool $no_ack
     * @param bool $exclusive
     * @param bool $nowait
     * @param int|null $ticket
     * @param array $arguments
     * @param string $consumer_tag
     */
    public function listen(
        $queue_name = null,
        $no_local = false,
        $no_ack = true,
        $exclusive = false,
        $nowait = false,
        $ticket = null,
        $consumer_tag = '',
        $arguments = []
    ){

        $client = $this;

        $queue_name = $queue_name?$queue_name:$this->req_queue_name;

        $this->channel->basic_consume(
            $queue_name,
            $consumer_tag,
            $no_local,
            $no_ack,
            $exclusive,
            $nowait,
            function(AMQPMessage $msg) use ($client) {
                $client->handle($msg);
            },
            $ticket = null,
            $arguments
        );

        while (count($this->channel->callbacks)) {
            $this->channel->wait();
        }
    }
}