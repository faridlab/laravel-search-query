<?php

namespace SearchQuery\FilterQueryString\Filters\BetweenClauses;

trait WhereBetweenClause
{
    private function between($query, $filter, $values)
    {
        $query->whereBetween($filter, (array) $values);
        return $query;
    }
}