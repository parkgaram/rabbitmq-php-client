<?php

namespace Dna\RabbitMq\Simple\Basic;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AbstractConnection;

use Dna\RabbitMq\Contracts\Basic\Receiver as BaseReceiver;

use Dna\RabbitMq\Traits\CloseTrait;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class Receiver extends BaseReceiver
{
    use CloseTrait;
    
    private $url;
    private $port;
    private $username;
    private $pass;

    private function __construct() {
        
    }

    /**
     * Creating Basic Receiver
     *
     * @param string $url
     * @param integer $port
     * @param string $username
     * @param string $pass
     * @param string $vhost
     * @param string $req_queue_name
     * @return Receiver
     */
    public static function create(
        string $url            = 'localhost',
        int    $port           = 5672,
        string $username       = 'guest',
        string $pass           = 'guest',
        string $vhost          = '/',
        string $req_queue_name = null
    ) : Receiver
    {
        $instance = new Receiver();

        $instance->url      = $url;
        $instance->port     = $port;
        $instance->username = $username;
        $instance->pass     = $pass;
        $instance->vhost    = $vhost;
        if($req_queue_name)
            $instance->req_queue_name = $req_queue_name;
        $instance->init();

        return $instance;
    }

    protected function initConnection() : AbstractConnection
    {
        return new AMQPStreamConnection(
            $this->url,
            $this->port,
            $this->username,
            $this->pass,
            $this->vhost
        );
    }

    protected function declareExchange()
    {
        //DO NOTHING
    }
    
    protected function declareQueue()
    {
        $this->channel->queue_declare($this->req_queue_name, false, false, false, false);
    }

    protected function handle(AMQPMessage $msg){
        print_r($msg->body);
    }
}