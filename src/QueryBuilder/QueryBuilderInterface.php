<?php

namespace Prettysql\QueryBuilder;

interface QueryBuilderInterface
{
    public function run();
    public function write();

    public function create($tableName);
    public function insert();
    public function select();
}
