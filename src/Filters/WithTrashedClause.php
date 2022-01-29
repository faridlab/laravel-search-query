<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class WithTrashedClause extends BaseClause {

    protected function apply($query): Builder
    {
        if($this->values == 'true') {
            $query->withTrashed();
        }
        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
