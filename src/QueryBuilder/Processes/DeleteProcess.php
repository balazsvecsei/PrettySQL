<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;
use Prettysql\QueryBuilder\Traits\ConditionTrait;

class DeleteProcess extends AbstractProcess
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

    public const DELETE = "DELETE FROM ";

    public $deleteAll = false;


    public function createQuery()
    {
        if ($this->deleteAll) {
            $query = "TRUNCATE `$this->tableName`;";
            $this->query = $query;
            return $query;
        }
        $this->query = self::DELETE . "`$this->tableName`" . $this->renderConditions();

        return $this;
    }

    public function all()
    {
        $this->deleteAll = true;
        return $this;
    }
}
