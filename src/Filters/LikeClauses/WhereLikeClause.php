<?php

namespace GrammaticalQuery\FilterQueryString\Filters\LikeClauses;

trait WhereLikeClause
{
    private function like($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->orWhere($filter, 'like', "%$value%");
        }
        return $query;
    }
}