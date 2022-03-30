<?php

namespace Prettysql;

class PSql
{

    public $table;
    public string $query;

    private $process;

    public Database $database;

    public static PSql $psql;

    public function __construct(Database $database, string $table = null)
    {
        $this->defineTable($table);

        $this->database = $database;

        self::$psql = $this;
    }

    private $processClasses = [
        "create" => QueryBuilder\Processes\CreateProcess::class,
        "insert" => QueryBuilder\Processes\InsertProcess::class,
        "select" => QueryBuilder\Processes\SelectProcess::class,
        "delete" => QueryBuilder\Processes\DeleteProcess::class,
    ];

    public function defineTable($table)
    {
        $this->table = $table;
    }

    public static function __callStatic(string $statement, array $params)
    {
        if (array_key_exists($statement, self::$psql->processClasses)) {
            $tableName = array_key_exists(0, $params) ? $params[0] : self::$psql->table;

            $process = new self::$psql->processClasses[$statement]();

            $process = $process->setTable($tableName);

            self::$psql->process = $process;

            return $process;
        }
    }

    public function exec()
    {
        $query = $this->process->getQuery();

        if ($this->process::class ==  $this->processClasses["select"]) {
            return $this->database->exec($query)->fetchAll();
        } else {
            $this->database->exec($query);
        }
    }
}
