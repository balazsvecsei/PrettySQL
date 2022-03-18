<?php

namespace Prettysql\QueryBuilder;

class QueryBuilder implements QueryBuilderInterface
{

    private $table;
    private $query;

    private $statement;



    public function __construct($table = null)
    {
        if (isset($table))
            $this->table = $table;
    }

    public function write()
    {
        echo $this->query;
    }

    public function run()
    {
        return $this->query;
    }

    public function create($tableName)
    {
        $this->statement = new Statements\CreateStatement($tableName);

        return $this->statement;
    }

    public function select()
    {
        $this->statement = new Statements\SelectStatement();
    }

    public function insert()
    {
        $this->statement = new Statements\InsertStatement();
    }


    public function __destruct()
    {
        if (!isset($this->query))
            return false;

        $this->query = $this->statement->getQuery();
        $this->write();
    }
}
