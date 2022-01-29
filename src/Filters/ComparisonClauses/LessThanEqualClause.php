<?php

namespace SearchQuery\FilterQueryString\Filters\ComparisonClauses;

trait LessThanEqualClause
{
    private function lessThanEqual($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '<=', $value);
        }
        return $query;
    }
}
