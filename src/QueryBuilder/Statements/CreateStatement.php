<?php

namespace Prettysql\QueryBuilder\Statements;

class CreateStatement implements StatementInterface
{
    public $query = "CREATE TABLE";
    public $tableName;

    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        $this->query .= " '$tableName'";
        return $this;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function addColumn($name, $key, $type, $size, $nullable)
    {
        # code...
    }

    public function integer($columnName)
    {
        # code...
    }

    public function string($name, $size = 255)
    {
        # code...
    }

    public function id()
    {
        # code...
    }
}
