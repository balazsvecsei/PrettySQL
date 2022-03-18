<?php

namespace PrettySql;

use Prettysql\QueryBuilder\QueryBuilder;

class PrettySql
{
    private QueryBuilder $queryBulder;
    public function __construct()
    {
        $this->queryBulder = new QueryBuilder();
    }
}
