<?php

namespace Dna\RabbitMq\Contracts;
use  PhpAmqpLib\Connection\AbstractConnection;

abstract class Client
{
    protected $req_queue_name = '';
    protected $exchange_name  = '';
    protected $vhost          = '/';

    /**
     * @var AbstractConnection
     */
    protected $connection;
    /**
     * @var PhpAmqpLib\Channel\AMQPChannel
     */
    protected $channel;
    
    protected function init(){
    
        $this->connection = $this->initConnection();
        $this->channel    = $this->connection->channel();
        
        $this->declareExchange();
        $this->declareQueue();

    }
    
    /**
     * Initializing Connection
     * 
     * You could choice what you use
     * - AMQPStreamConnection
     * - AMQPSSLConnection
     * - Etc(implementing AbstractConnection)
     * 
     * returned value will be assigned to $this->connection.
     * check init() function.
     * @return AbstractConnection $connection
     */    
    abstract protected function initConnection() : AbstractConnection;

    /**
     * use channel->exchange_declare(~)
     * 
     * you could check sample code blow.
     * 
     * ```php
     * $this->channel->exchange_declare(
     *      'exchang_name',
     *      'type',
     *      ....
     *   );
     *  ```
     * @return void
     */
    abstract protected function declareExchange();
    /**
     * use channel->queue_declare(~)
     * 
     * you could check sample code blow.
     * 
     * ```php
     * $this->channel->queue_declare(
     *      ....
     *   );
     *  ```
     * @return void
     */
    abstract protected function declareQueue();

    /**
     * close channel and connection
     * @return void
     */
    abstract public function close();
}