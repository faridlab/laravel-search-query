<?php

namespace SearchQuery\FilterQueryString\Filters\BetweenClauses;

trait WhereInClause
{
    private function in($query, $filter, $values)
    {
        $query->whereIn($filter, (array) $values);
        return $query;
    }
}