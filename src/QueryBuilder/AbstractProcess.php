<?php

namespace Prettysql\QueryBuilder;

abstract class AbstractProcess
{
    public $query;
    public $columns = [];
    public $primaryKey = null;

    abstract function createQuery();

    public function getQuery(): string
    {

        $this->createQuery();

        return str_replace(["@@", "-----"], '', $this->query);
    }

    public function write()
    {
        $this->createQuery();
        $query = str_replace("@@", '<br>', $this->query);
        $query = str_replace("-----", ' &emsp;', $query);
        return $query;
    }

    public function exec()
    {
        $this->getQuery();
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
                }



                return implode(" ", $column);
            },
            $this->columns
        );

        $columns = implode(", @@-----", $columns);

        if ($this->primaryKey) $columns .= ", @@PRIMARY KEY ($this->primaryKey)";

        return (string) $columns;
    }
}
