<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class OrderClause extends BaseClause {

    protected function apply($query): Builder
    {
        if(is_array($this->values)) {
            foreach ((array) $this->values as $field => $order) {
                $order = $order == 'asc'? 'asc': 'desc';
                $query->orderBy($field, $order);
            }
        } else {
            $query->orderBy($this->values, 'asc');
        }
        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
