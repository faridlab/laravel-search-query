<?php

namespace GrammaticalQuery\FilterQueryString\Filters\LikeClauses;

trait WhereNotContainClause
{
    private function notContain($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->orWhere($filter, 'not like', "%$value%");
        }
        return $query;
    }
}