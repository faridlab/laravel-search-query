<?php

namespace GrammaticalQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class LimitClause extends BaseClause {

    protected $page = 1;
    protected $limit = 25;

    protected function apply($query): Builder
    {
        $method = $this->filter;
        return $this->{$method}($query, $this->filter, $this->values);
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

    private function page($query, $filter, $values)
    {
        $limit = $this->limit;
        $p = intval($values);
        $page = ($p > 0 ? $p - 1: $p);

        $query->offset($page * $limit);

        return $query;
    }

    private function limit($query, $filter, $values)
    {
        $limit = intval($values);
        if ($limit < 25) {
            $limit = 25;
        } elseif($limit > 100) {
            $limit = 100;
        }
        $this->limit = $limit;
        $query->limit($limit);

        return $query;
    }
}
