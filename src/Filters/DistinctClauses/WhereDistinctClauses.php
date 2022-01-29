<?php

namespace SearchQuery\FilterQueryString\Filters\DistinctClauses;

trait WhereDistinctClauses
{
    private function distinct($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->distinct($filter);
        }
        return $query;
    }
}
