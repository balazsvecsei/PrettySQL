<?php

namespace Prettysql;

class PSql implements QueryBuilder\PrettysqlInterface
{

    private $table;
    public string $query;

    private $process;

    private $processClasses = [
        "create" => QueryBuilder\Processes\CreateProcess::class,
        "insert" => QueryBuilder\Processes\InsertProcess::class,
        "select" => QueryBuilder\Processes\SelectProcess::class,
    ];


    public function run()
    {
        return $this->query;
    }

    public function create($tableName)
    {
        $process = new $this->processClasses["create"]();
        $process = $process->setTable($tableName);

        $this->process = $process;
        return $this->process;
    }

    public function select()
    {
        $this->Process = new QueryBuilder\Processes\SelectProcess();
    }

    public function insert()
    {
        $this->Process = new QueryBuilder\Processes\InsertProcess();
    }
}
