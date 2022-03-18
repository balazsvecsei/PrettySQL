<?php

namespace Prettysql\QueryBuilder\Statements;

class SelectStatement implements StatementInterface
{
    public function getQuery(): string
    {
        return $this->query;
    }
}
