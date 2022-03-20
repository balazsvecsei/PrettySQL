<?php

namespace Prettysql\QueryBuilder;

interface PrettysqlInterface
{

    public function create($tableName);
    public function insert();
    public function select();
}
