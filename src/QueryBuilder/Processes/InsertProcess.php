<?php

namespace Prettysql\QueryBuilder\Processes;

class InsertProcess implements ProcessInterface
{
    public function getQuery(): string
    {
        return $this->query;
    }
}
