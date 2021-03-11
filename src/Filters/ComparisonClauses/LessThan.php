<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses;

trait LessThan
{
    private function lessThan($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '<', $value);
        }
        return $query;
    }
}