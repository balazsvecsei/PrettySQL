<?php

namespace Prettysql\QueryBuilder\Statements;

class InsertStatement implements StatementInterface
{
    public function getQuery(): string
    {
        return $this->query;
    }
}
