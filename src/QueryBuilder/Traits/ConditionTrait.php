<?php

namespace Prettysql\QueryBuilder\Traits;

trait ConditionTrait
{
    public $conditionArray = [];

    /**
     * whereIs
     * Add WHERE $column = $value condition to query
     *
     * @param  mixed $column
     * @param  mixed $value
     * @return void
     */
    public function whereIs(string $column, $value)
    {
        return $this->and($column, '=', $value);
    }

    /**
     * whereId
     * Shorthand to whereIs method
     *
     * @param  mixed $id
     * @return void
     */
    public function whereId(int $id)
    {
        return $this->and('id', '=', $id);
    }


    /**
     * and
     * Define logical condition to query with AND operator
     * ex.: [existing condition...] AND price > 120
     *
     * @param  mixed $column
     * @param  mixed $operator
     * @param  mixed $value
     * @return void
     */
    public function and($column, $operator, $value)
    {
        array_push($this->conditionArray, ["AND", $column, $operator, $value]);
        return $this;
    }

    /**
     * or
     * Define logical condition to query with OR operator
     * ex.: [existing condition...] OR price > 120
     *
     * @param  mixed $column
     * @param  mixed $operator
     * @param  mixed $value
     * @return void
     */
    public function or($column, $operator, $value)
    {
        array_push($this->conditionArray, ["OR", $column, $operator, $value]);
        return $this;
    }

    /**
     * renderConditions
     * Generate logical conditions into the query
     * 
     * @return string
     */
    public function renderConditions(): string
    {
        if (empty($this->conditionArray)) return "";

        $filter = "";

        $index = 1;
        foreach ($this->conditionArray as $condition) {

            if ($index != 1)
                $filter .= " $condition[0] ";

            $condition[3] = is_string($condition[3]) ? "'{$condition[3]}'" : $condition[3];
            $filter .= " `$condition[1]` $condition[2] $condition[3]";

            $index++;
        }

        return " WHERE $filter ";
    }
}
