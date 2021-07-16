<?php

namespace GrammaticalQuery\FilterQueryString\Filters\LikeClauses;

trait WhereStartWithClause
{
    private function startWith($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, 'like', "$value%");
            }
        });
      
        return $query;
    }
}