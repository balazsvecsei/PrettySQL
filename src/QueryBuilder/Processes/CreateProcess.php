<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;

class CreateProcess extends AbstractProcess
{
    public $query;
    public $tableName;
    public const CREATE = "CREATE TABLE";

    private $columns = [];

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
        $query = self::CREATE . " " . $this->tableName;

        if (!empty($this->columns)) {
            $columns = array_map(
                function ($column) {
                    return implode(" ", [
                        "name" => $column["name"],
                        "key" => $column["key"] ? "" : "",
                        "type" => $column["type"],
                        "size" => $column["size"],
                        "nullable" => $column["nullable"] ? "" : "NOT NULL",
                        "uniqe" => $column["uniqe"] ? "UNIQUE" : "",

                    ]);
                },
                $this->columns
            );
            $columns = implode(", ", $columns);
            $query = "$query ($columns)";
        }

        $this->query = $query;

        return $this;
    }

    public function addColumn($name, $key, $type, $size, $nullable, $uniqe)
    {
        array_push($this->columns, [
            "col_name" => $name,
            "col_key" => $key,
            "col_type" => $type,
            "col_size" => $size,
            "col_nullable" => $nullable,
            "col_uniqe" => $uniqe,
        ]);
        return $this;
    }



    public function setColumn($columnName, $attributes)
    {
        $selectedColumnIndex = array_search("'$columnName'", array_column($this->columns, "col_name"));

        $column = $this->columns[$selectedColumnIndex];

        foreach ($attributes as $key => $value)
            if (array_key_exists($key, $attributes))
                $column[$key] = $value;
            else
                return false;

        $this->columns[$selectedColumnIndex] = $column;

        return $this;
    }

    public function integer($columnName)
    {
        $this->addColumn("'$columnName'", false, "INT", null, true, false);
        return $this;
    }

    public function string($columnName, $size = 255)
    {
        $this->addColumn("'$columnName'", null, "VARCHAR($size)", null, true, false);
        return $this;
    }

    public function id()
    {
        # code...
        return $this;
    }
}
