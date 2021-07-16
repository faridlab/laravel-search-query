<?php

namespace GrammaticalQuery\FilterQueryString\Filters\LikeClauses;

trait WhereNotLikeClause
{
    private function notLike($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, 'not like', "$value");
            }
        });
       
        return $query;
    }
}