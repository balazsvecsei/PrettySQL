<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;

class CreateProcess extends AbstractProcess
{
    public $query;
    public $tableName;
    public const INIT_METHOD = "CREATE TABLE";

    private $columns = [];

    public function __construct()
    {
    }

    public function setTable($name)
    {
        $this->tableName = $name;
        return $this;
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function createQuery()
    {
        $query = self::INIT_METHOD . " " . $this->tableName;

        $columns = "";

        if (!empty($this->columns)) {
            foreach ($this->columns as $column) {
                $columns .= " " . $column['name'] . " " . $column['type'] . " " . $column['nullable'];
            }
            $query .= "$query ($columns)";
        }

        $this->query = $query;

        return $this;
    }



    public function addColumn($name, $key, $type, $size, $nullable)
    {
        array_push($this->columns, [
            "name" => $name,
            "key" => $key,
            "type" => $type,
            "size" => $size,
            "nullable" => $nullable,
        ]);
        return $this;
    }

    public function integer($columnName)
    {
        $this->addColumn($columnName, null, "INT", 50, true);
        return $this;
    }

    public function string($name, $size = 255)
    {
        # code...
        return $this;
    }

    public function id()
    {
        # code...
        return $this;
    }
}
