<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;

class SelectProcess extends AbstractProcess
{
    public const SELECT = "SELECT";

    public $limit = 1000;

    public $orderBy = false;

    public $sorting = "DESC";

    public function createQuery(): string
    {
        $query = self::SELECT;

        if (empty($this->columns)) {
            $columns = '*';
        } else {
            $columns = implode(", ", array_map(fn ($column) => `$this->column`, $this->columns));
        }
        $query .= " $columns FROM `$this->tableName`";

        if ($this->orderBy) {
            $query .= " ORDER BY `$this->orderBy` $this->sorting";
        }


        $query .= " LIMIT $this->limit;";

        $this->query = $query;
        return $this->query;
    }

    public function all()
    {
        return $this->get();
    }

    public function get($columns = [])
    {
        $this->columns = $columns;
        return $this;
    }

    public function first()
    {
        $this->setLimit(1);
        return $this;
    }

    public function orderBy($columnName = 'id')
    {
        $this->orderBy = $columnName;
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
}
