<?php

require __DIR__ . '/../../vendor/autoload.php';

use Dna\RabbitMq\Simple\Basic\Receiver;
use PhpAmqpLib\Message\AMQPMessage;

$receiver = Receiver::create('localhost',32769);
$receiver->listen();
$receiver->close();
