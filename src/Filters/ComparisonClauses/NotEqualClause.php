<?php

namespace SearchQuery\FilterQueryString\Filters\ComparisonClauses;

trait NotEqualClause
{
    private function notEqual($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '!=', $value);
        }
        return $query;
    }
}
