<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses;

trait LessThanEqual
{
    private function lessThanEqual($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '<=', $value);
        }
        return $query;
    }
}
