<?php

namespace SearchQuery\FilterQueryString\Filters\LikeClauses;

trait WhereStartWithClause
{
    private function startWith($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->orWhere($filter, 'like', "$value%");
        }
        return $query;
    }
}