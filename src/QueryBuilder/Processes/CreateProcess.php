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
            $columns = array_map(fn ($column) => implode(" ", [
                "name" => $column["name"],
                "key" => $column["key"],
                "type" => $column["type"],
            ]), $this->columns);
            $columns = implode(", ", $columns);
            $query = "$query ($columns)";
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
        $this->addColumn("'$columnName'", null, "INT", null, true);
        return $this;
    }

    public function string($columnName, $size = 255)
    {
        $this->addColumn("'$columnName'", null, "VARCHAR($size)", null, true);
        return $this;
    }

    public function id()
    {
        # code...
        return $this;
    }
}
