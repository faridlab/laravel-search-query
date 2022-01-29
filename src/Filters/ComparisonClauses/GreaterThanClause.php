<?php

namespace SearchQuery\FilterQueryString\Filters\ComparisonClauses;

trait GreaterThanClause
{
    private function greaterThan($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '>', $value);
        }
        return $query;
    }
}
