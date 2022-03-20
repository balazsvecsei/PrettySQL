<?php

namespace Prettysql\QueryBuilder\Processes;

class SelectProcess implements ProcessInterface
{
    public function getQuery(): string
    {
        return $this->query;
    }
}
