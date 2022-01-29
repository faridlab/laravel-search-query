<?php

namespace SearchQuery\FilterQueryString\Filters\LikeClauses;

trait WhereEndWithClause
{
    private function endWith($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->orWhere($filter, 'like', "%$value");
        }
        return $query;
    }
}