<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;
use Prettysql\QueryBuilder\Traits\ConditionTrait;

class SelectProcess extends AbstractProcess
{
    /* AbstractProcess

    $this->$tableName;
    $this->$query;
    $this->$columns = [];
    $this->$primaryKey = null;
    $this->$columnTemplate;

    $this->getQuery(): string
    $this->write()
    $this->exec()
    $this->renderColumns()
    $this->getColumnsFromDb()
    */

    /* ConcitionTrait
    $this->whereIs(string $column, $value): SelectProcess;
    $this->whereId(int $id): SelectProcess;
    $this->and($column, $operator, $value): SelectProcess;
    $this->or($column, $operator, $value): SelectProcess;
    $this->renderConditions(): string;
    */
    use ConditionTrait;



    public const SELECT = "SELECT";

    public $limit = 100;

    public $orderBy = false;

    public $sorting = "ASC";

    public $like = "";

    public $selectedColumns = [];


    /**
     * createQuery
     * 
     * Generate Query string, and store in object.
     *
     * @return string
     */
    public function createQuery(): string
    {
        $query = self::SELECT;

        $selectedColumns = $this->selectedColumns;

        if (empty($selectedColumns)) {
            $selectedColumns = '*';
        } else {
            $selectedColumns = implode(", ", array_map(fn ($column) => "`$column`", $selectedColumns));
        }
        $query .= " $selectedColumns FROM `$this->tableName`";

        $query .= $this->renderConditions();

        $query .= $this->like;

        if ($this->orderBy) {
            $query .= " ORDER BY `$this->orderBy` $this->sorting";
        }

        if (empty($this->conditionArray))
            $query .= " LIMIT $this->limit";

        $this->query = "$query;";

        return $this->query;
    }



    /**
     * first
     * First n item in table. Default: n = 1
     * Shorthand to setLimit() method
     *
     * @param  mixed $count
     * @return void
     */
    public function first($count = 1)
    {
        $this->setLimit($count);
        return $this;
    }

    /**
     * last
     * Last n item in table. Default: n = 1
     *
     * @param  mixed $count
     * @return void
     */
    public function last(int $count = 1)
    {
        $this->orderBy('id', "DESC");
        $this->setLimit($count);
        return $this;
    }

    /**
     * orderBy
     * Set order and sort
     *
     * @param  mixed $columnName
     * @param  mixed $sorting
     * @return void
     */
    public function orderBy($columnName = 'id', $sorting = "ASC")
    {
        $this->orderBy = $columnName;
        $this->sorting = $sorting;
        return $this;
    }

    /**
     * selectColumns
     * Selecting columns
     * ex.: ["Firstame", "Lastname", "email"]
     *
     * @param  mixed $selectedColumns
     * @return void
     */
    public function selectColumns(array $selectedColumns)
    {
        $this->selectedColumns = $selectedColumns;
        return $this;
    }

    /**
     * setLimit
     * Set quantity of rows
     *
     * @param  mixed $limit
     * @return void
     */
    public function setLimit(int $limit)
    {
        $this->limit = $limit;
        return $this;
    }


    /**
     * like
     * Add WHERE-LIKE operator to query
     * 
     * $mode = anywhere // The string can be anywhere in the text
     * $mode = startwith // The text starts with the string
     * $mode = ending // The text ends with a string
     *
     * @param  mixed $column
     * @param  mixed $text
     * @param  mixed $mode
     * @return void
     */
    public function like(string $column, string $text, $mode = "anywhere")
    {
        $like = " WHERE `$column` LIKE ";

        switch ($mode) {
            case "anywhere":
                $like .= "'%$text%'";
                break;
            case "startwith":
                $like .= "'$text%'";
                break;
            case "ending":
                $like .= "'%$text'";
                break;
        }

        $this->like = $like;
        return $this;
    }

    /**
     * renderConditions
     * Generate logical conditions into the query
     * 
     * @return string
     */
    public function renderConditions(): string
    {
        if (empty($this->conditionArray)) return "";

        $filter = "";

        $index = 1;
        foreach ($this->conditionArray as $condition) {

            if ($index != 1)
                $filter .= " $condition[0] ";

            $condition[3] = is_string($condition[3]) ? "'{$condition[3]}'" : $condition[3];
            $filter .= " `$condition[1]` $condition[2] $condition[3]";

            $index++;
        }

        return " WHERE $filter ";
    }
}
