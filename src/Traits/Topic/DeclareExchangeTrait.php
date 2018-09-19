<?php

namespace Dna\RabbitMq\Traits\Topic;

trait DeclareExchangeTrait
{
    protected function declareExchange()
    {
        $this->channel->exchange_declare(
            $this->exchange_name,
            'topic',
            false, false, false
        );
    }
}