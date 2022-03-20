<?php

namespace Prettysql\QueryBuilder;

abstract class AbstractProcess
{
    public $query;

    abstract function createQuery();

    public function getQuery(): string
    {
        $this->createQuery();
        return $this->query;
    }

    public function exec()
    {
        $this->getQuery();
    }
}
