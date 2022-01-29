<?php

namespace SearchQuery\FilterQueryString\Filters\BetweenClauses;

trait WhereNotInClause
{
    private function notIn($query, $filter, $values)
    {
        $query->whereNotIn($filter, (array) $values);
        return $query;
    }
}