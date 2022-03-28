<?php

namespace Prettysql\QueryBuilder;

interface PrettysqlInterface
{

    public static function create($tableName);
    public function insert($tableName);
    public function select($tableName);
}
