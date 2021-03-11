<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses;

trait GreaterThanEqual
{
    private function greaterThanEqual($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '>=', $value);
        }
        return $query;
    }
}
