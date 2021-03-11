<?php

namespace GrammaticalQuery\FilterQueryString\Filters\LikeClauses;

trait WhereNotLikeClause
{
    private function notLike($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->orWhere($filter, 'not like', "$value");
        }
        return $query;
    }
}