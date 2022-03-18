<?php

namespace Prettysql\QueryBuilder\Statements;

interface StatementInterface
{
    public function getQuery(): string;
}
