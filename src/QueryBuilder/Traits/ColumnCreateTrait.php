<?php

namespace Prettysql\QueryBuilder\Traits;

trait ColumnCreateTrait
{
    public function integer(
        $columnName,
        $size = null,
        $nullable = true,
        $uniqe = false,
        $default = "NULL",
        $key = false,
        $type = "INT",
        $autoincrement = false
    ) {
        $this->addColumn($columnName, [
            "col_key" => $key,
            "col_type" => $type,
            "col_size" => $size,
            "col_nullable" => $nullable,
            "col_uniqe" => $uniqe,
            "col_default" => $default,
            "col_autoincrement" => $autoincrement
        ]);

        return $this;
    }

    public function string(
        $columnName,
        $size = 50,
        $nullable = true,
        $uniqe = false,
        $default = "NULL",
        $key = false,
        $type = "VARCHAR",
        $autoincrement = false
    ) {
        $this->addColumn($columnName, [
            "col_key" => $key,
            "col_type" => $type,
            "col_size" => $size,
            "col_nullable" => $nullable,
            "col_uniqe" => $uniqe,
            "col_default" => $default,
            "col_autoincrement" => $autoincrement
        ]);
        return $this;
    }
}
