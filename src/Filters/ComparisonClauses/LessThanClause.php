<?php

namespace SearchQuery\FilterQueryString\Filters\ComparisonClauses;

trait LessThanClause
{
    private function lessThan($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '<', $value);
        }
        return $query;
    }
}