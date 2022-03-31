<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;


class DropProcess extends AbstractProcess
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

    public const DROP = "DROP TABLE IF EXISTS";

    public function createQuery()
    {
        $this->query = self::DROP . " `$this->tableName`;";

        return $this->query;
    }
}
