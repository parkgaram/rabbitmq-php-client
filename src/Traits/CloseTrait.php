<?php

namespace Dna\RabbitMq\Traits;

trait CloseTrait
{
    public function close(){
        if($this->channel)
            $this->channel->close();

        if($this->connection)
            $this->connection->close();
    }
}