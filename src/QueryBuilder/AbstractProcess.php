<?php

namespace Prettysql\QueryBuilder;

use Prettysql\PSql;

abstract class AbstractProcess
{
    public $tableName;
    public $query;
    public $columns = [];
    public $primaryKey = null;
    public $columnTemplate;

    abstract function createQuery();

    public function setTable($name)
    {
        $this->tableName = $name;
        return $this;
    }

    public function getQuery(): string
    {

        $this->createQuery();

        $queryUnformatted = str_replace(["@@", "-----"], '', $this->query);

        return $queryUnformatted;
    }

    public function write()
    {
        $this->createQuery();

        $query = str_replace("@@", '<br>', $this->query);
        $query = str_replace("-----", ' &emsp;', $query);
        echo $query;
    }

    public function exec()
    {
        return \Prettysql\PSql::$psql->exec();
    }

    public function renderColumns()
    {

        $columns = array_map(
            function ($column) {

                $column['col_default'] = $column['col_default'] ? 'DEFAULT ' . $column['col_default'] : '';

                foreach ($column as $key => $value) {
                    if ($key == "col_key" && $value == true) {
                        $this->primaryKey = $column["col_name"];
                        unset($column['col_key']);
                    }
                    if ($key == "col_name") {
                        $column[$key] = "`$value`";
                    }
                    if ($key == "col_nullable" && $value == true) {
                        unset($column['col_nullable']);
                    }
                    if ($key == "col_nullable" && $value == false) {
                        $column[$key] = "NOT NULL";
                    }

                    if ($key == "col_type" && $value == "VARCHAR") {
                        $column[$key] = $value . "(" . $column['col_size'] . ")";
                        unset($column['col_size']);
                    }

                    if ($key == "col_type" && $value == "INT") {
                        unset($column['col_default']);
                    }

                    if ($key == "col_autoincrement" && $value == true) {
                        $column[$key] = "AUTO_INCREMENT";
                    }
                }
                return implode(" ", $column);
            },
            $this->columns
        );

        $columns = implode(", @@-----", $columns);

        if ($this->primaryKey) $columns .= ", @@PRIMARY KEY ($this->primaryKey)";

        return (string) $columns;
    }


    public function getColumnsFromDb()
    {
        $this->columnTemplate = PSql::$psql->database
            ->exec("SELECT *
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_NAME = N'{$this->tableName}'")
            ->fetchAll();
        return $this->columnTemplate;
    }

    public function __destruct()
    {
        //echo $this->write();
    }
}
