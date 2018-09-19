<?php

require __DIR__ . '/../../vendor/autoload.php';

use Dna\RabbitMq\Simple\Basic\Sender;
use PhpAmqpLib\Message\AMQPMessage;

$sender = Sender::create('localhost',32769);
$sender->publish(new AMQPMessage('sadfsdf world'));
$sender->close();
