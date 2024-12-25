<?php

namespace SearchQuery\FilterQueryString\Filters\LikeClauses;

trait WhereILikeClause
{
    private function ilike($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, 'ilike', "%$value%");
            }
        });

        return $query;
    }
}