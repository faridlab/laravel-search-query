<?php

namespace GrammaticalQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class SearchClause extends BaseClause {

    protected function apply($query): Builder
    {
        if(is_array($this->values)) return $query;
        $model = $query->getModel();
        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $value = $this->values;
        $query->where(function($query) use($columns, $value) {
            foreach ($columns as $field) {
                if(in_array($field, ['created_at', 'updated_at', 'deleted_at'])) continue;
                $query->orWhere($field, 'like', "%$value%");
            }
        });

        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
