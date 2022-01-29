<?php

namespace SearchQuery\FilterQueryString\Filters\ComparisonClauses;

trait GreaterThanEqualClause
{
    private function greaterThanEqual($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '>=', $value);
        }
        return $query;
    }
}
