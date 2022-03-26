earl<?php

    use PHPUnit\Framework\TestCase;
    use Prettysql\PSql;

    class PrettyTest extends TestCase
    {
        public $prettySql;

        public function __construct()
        {
            $this->prettySql = new PSql();
        }

        public function test_prettySql_object()
        {

            $this->assertIsObject($this->prettySql);
        }

        public function test_create_table()
        {
            $table = (new PSql())->create("users")->getQuery();

            $this->assertIsString($table);
        }
    }
