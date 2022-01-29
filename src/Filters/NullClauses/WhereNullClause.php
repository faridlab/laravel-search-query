<?php

namespace SearchQuery\FilterQueryString\Filters\NullClauses;

trait WhereNullClause
{
    private function isNull($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->whereNull($filter);
        }
        return $query;
    }
}
