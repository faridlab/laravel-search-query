<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class CountClause extends BaseClause {

    protected function apply($query): Builder
    {
        if(is_array($this->values)) {
            foreach ((array) $this->values as $relation) {
                $query->withCount([$relation]);
            }
        } else {
            $query->withCount([$this->values]);
        }
        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
