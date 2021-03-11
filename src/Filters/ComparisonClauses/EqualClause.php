<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses;

trait EqualClause
{
    private function equal($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, '=', $value);
        }
        return $query;
    }
}
