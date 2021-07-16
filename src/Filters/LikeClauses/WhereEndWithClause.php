<?php

namespace GrammaticalQuery\FilterQueryString\Filters\LikeClauses;

trait WhereEndWithClause
{
    private function endWith($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, 'like', "%$value");
            }
        });
        
        return $query;
    }
}