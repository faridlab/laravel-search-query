<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class RelationshipClause extends BaseClause {

    protected function apply($query): Builder
    {
        if(is_array($this->values)) {
            foreach ((array) $this->values as $relation) {
                $query->with([$relation => function($query) {
                    $query->withTrashed();
                }]);
            }
        } else {
            $query->with([$this->values => function($query) {
                $query->withTrashed();
            }]);
        }
        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
