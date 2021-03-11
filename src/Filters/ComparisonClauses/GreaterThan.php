<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses;

trait GreaterThan
{
    private function greaterThan($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '>', $value);
        }
        return $query;
    }
}
