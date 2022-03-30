<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;
use Prettysql\QueryBuilder\Traits\ConditionTrait;

class DeleteProcess extends AbstractProcess
{
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
