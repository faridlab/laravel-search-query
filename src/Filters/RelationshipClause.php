<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;

class RelationshipClause extends BaseClause {

    protected function apply($query): Builder
    {
        if(is_array($this->values)) {
            foreach ((array) $this->values as $relation => $value) {
                if(!is_numeric($relation)) {
                    // relationship[showcases]=search-value -> default field ID
                    // relationship[showcases][field]=search-value
                    $query->with([$relation => function($query) use($value) {
                        if(is_array($value)) {
                            foreach ((array) $value as $filter => $search) {
                                $query->where($filter, $search);
                            }
                            $query->withTrashed();
                            return;
                        }
                        $filter = 'id';
                        $query->where($filter, $value)->withTrashed();
                    }]);
                    continue;
                }

                $query->with([$value => function($query) {
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
