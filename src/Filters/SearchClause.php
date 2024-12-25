<?php

namespace SearchQuery\FilterQueryString\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class SearchClause extends BaseClause {

    protected function apply($query): Builder
    {
        if(is_array($this->values)) return $query;
        $model = $query->getModel();
        $columns = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        $table_name = $model->getTable();
        $value = $this->values;
        $query->where(function($query) use($table_name, $columns, $value) {
            foreach ($columns as $field) {
                $query->orWhere("{$table_name}.{$field}", 'ilike', "%$value%");
            }
        });
        return $query;
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

}
