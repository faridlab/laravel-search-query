<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class SelectClause extends BaseClause {

    protected function apply($query): Builder
    {
        $query->addSelect('id');
        if(is_array($this->values)) {
            foreach ((array) $this->values as $value) {
                $query->addSelect($value);
            }
        } else {
            $query->addSelect($this->values);
        }
        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
