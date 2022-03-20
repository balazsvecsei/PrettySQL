<?php

namespace Prettysql\QueryBuilder\Processes;

interface ProcessInterface
{
    public function getQuery(): string;
}
