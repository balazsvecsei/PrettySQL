<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;
use \Prettysql\QueryBuilder\Traits\ColumnCreateTrait as ColumnsTrait;


class CreateProcess extends AbstractProcess
{
    use ColumnsTrait;

    public $query;
    public const CREATE = "CREATE TABLE";

    public $collate = "utf8_hungarian_ci";


    public function getTableName()
    {
        return $this->tableName;
    }

    public function createQuery()
    {

        $query = self::CREATE . " `$this->tableName`";

        if (!empty($this->columns)) {
            $columns = self::renderColumns();
            $query = "$query (@@$columns@@)";
        }

        $query .= " COLLATE='$this->collate';";

        $this->query = $query;

        return $this;
    }

    public function addColumn(string $name, array $attributes = ["col_type" => "VARCHAR"])
    {
        array_push($this->columns, array_merge(["col_name" => $name], $attributes));
        return $this;
    }


    public function setColumn($columnName, $attributes)
    {
        $selectedColumnIndex = $this->getColumnIndexByName($columnName);

        $column = $this->columns[$selectedColumnIndex];

        foreach ($attributes as $key => $value)
            if (array_key_exists($key, $attributes))
                $column[$key] = $value;
            else
                return false;

        $this->columns[$selectedColumnIndex] = $column;

        return $this;
    }

    public function getColumnIndexByName($columnName)
    {
        return array_search($columnName, array_column($this->columns, "col_name"));
    }

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

    public function setToPrimary($columnName)
    {

        $this->setColumn($columnName, ["col_key" => true, "col_nullable" => false, "col_autoincrement" => true]);

        return $this;
    }

    public function id()
    {
        $this->integer('id')->setToPrimary('id');

        return $this;
    }
}
