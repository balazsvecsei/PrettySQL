<?php

namespace Prettysql\QueryBuilder\Processes;

use Prettysql\QueryBuilder\AbstractProcess;


class DeleteProcess extends AbstractProcess
{
    public const DROP = "DROP";

    public function createQuery()
    {
        $this->query = self::DROP . $this->tableName;

        return $this;
    }
}
