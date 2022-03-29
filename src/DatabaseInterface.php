<?php

namespace Prettysql;

interface DatabaseInterface
{

    public function __construct();

    public function exec($query);
}
