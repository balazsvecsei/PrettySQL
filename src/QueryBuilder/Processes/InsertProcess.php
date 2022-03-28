<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;

class InsertProcess extends AbstractProcess
{
    private $rows = [];
    public const INSERT = "INSERT INTO";

    public function createQuery(): string
    {
        $query = self::INSERT . "   `$this->tableName` ";

        $columns = implode(", ", array_map(fn ($column) => "`$column`", $this->columns));

        $valueList = "";
        foreach ($this->rows as $row) {
            $value = implode(", ", array_map(fn ($value) => "'$value'", $row));
            $valueList .= "----- ($value)";
        }

        $query .= "($columns) @@VALUES@@ $valueList;";

        $this->query = $query;
        return $query;
    }

    public function row(array $row)
    {
        $this->createColumnTemplate($referenceRow = $row);
        array_push($this->rows, $row);
        return $this;
    }

    public function collection(array $collection)
    {
        $this->createColumnTemplate($collection[0]);
        $this->rows = array_merge($this->rows, $collection);
        return $this;
    }

    public function getRows()
    {
        return $this->rows;
    }

    public function createColumnTemplate(array $referenceRow = [], array $template = [], $override = false)
    {
        if (empty($this->columns) && $override == false)
            if (empty($referenceRow) && !empty($template)) {
                $this->columns = $template;
            } elseif (!empty($referenceRow) && empty($template)) {
                $this->columns = array_keys($referenceRow);
            } else {
                return false;
            }
        return true;
    }
}
