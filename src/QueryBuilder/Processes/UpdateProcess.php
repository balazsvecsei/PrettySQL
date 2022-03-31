<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;
use Prettysql\QueryBuilder\Traits\ConditionTrait;


class UpdateProcess extends AbstractProcess
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


    const UPDATE = "UPDATE";

    public array $valueCollection = [];

    public function createQuery()
    {
        //UPDATE `framework`.`users` SET `email`='' WHERE  `id`=1;
        $query = self::UPDATE . " `$this->tableName` SET ";

        if (!empty($this->valueCollection)) {
            $query .= $this->renderValues();
        } else return false;

        $query .= $this->renderConditions();

        $this->query = $query;
        return $this->query;
    }

    public function value(array $value)
    {
        array_push($this->valueCollection, $value);
        return $this;
    }

    public function values(array $values)
    {
        array_merge($this->valueCollection, $values);
        return $this;
    }

    public function renderValues()
    {

        $values = '';
        foreach ($this->valueCollection as $valuePair) {
            foreach ($valuePair as $key => $value) {
                $values .= " `$key` = '$value'";
            }
        }

        return $values;
    }
}
