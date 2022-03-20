<?php

use PHPUnit\Framework\TestCase;
use Prettysql\PSql;

class PrettyTest extends TestCase
{
    public $prettySql;
    public function test_prettySql_object()
    {
        $prettySql = new PSql();

        $this->assertIsObject($prettySql);
    }

    public function test_create_table()
    {
        $table = (new PSql())->create("users")->getQuery();

        $this->assertIsString($table);
    }
}
