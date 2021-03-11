<?php

namespace GrammaticalQuery\FilterQueryString\Filters\NullClauses;

trait WhereNotNullClause
{
    private function isNotNull($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->whereNotNull($filter);
        }
        return $query;
    }
}
