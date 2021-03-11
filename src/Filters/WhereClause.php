<?php

namespace GrammaticalQuery\FilterQueryString\Filters;

use GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\{
    EqualClause,
    GreaterThan,
    GreaterThanEqual,
    LessThan,
    LessThanEqual,
    NotEqualClause
};

use Illuminate\Database\Eloquent\Builder;

class WhereClause extends BaseClause {
    use EqualClause;
    use NotEqualClause;
    use GreaterThan;
    use GreaterThanEqual;
    use LessThan;
    use LessThanEqual;

    protected $availableFilters = [
        'default' => 'where',
        'where' => 'where',
        'orwhere' => 'orWhere',
        'eq' => 'equal',
        'gt' => 'greaterThan',
        'gtEq' => 'greaterThanEqual',
        'lt' => 'lessThan',
        'ltEq' => 'lessThanEqual',
        'notEq' => 'notEqual',
        'like' => 'like',
        'contain' => 'contain',
        'startwith' => 'startwith',
        'endwith' => 'endwith',
        'notlike' => 'notLike',
        'in' => 'in',
        'notin' => 'notIn',
        'between' => 'between',
        'notbetween' => 'notBetween',
        'isnull' => 'isNull',
        'isnotnull' => 'isNotNull',
    ];

    protected function apply($query): Builder
    {
        return $this->resolver($query, $this->filter, $this->values);
    }

    protected function validate($value): bool {
        return !is_null($value);
    }

    private function resolver($query, $filter, $values)
    {
        $method = $this->availableFilters['default'];
        if(is_array($values) && $this->isAssoc($values)) {
            foreach((array)$values as $key => $value) {
                $method = $this->availableFilters[$key] ?? $this->availableFilters['default'];
                $query = $this->{$method}($query, $filter, $value);
            }
        } else {
            $query = $this->{$method}($query, $filter, $values);
        }
        return $query;
    }

    private function isAssoc(array $array) {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

    private function orWhere($query, $filter, $values)
    {
        $query->where(function($query) use($values, $filter) {
            foreach((array)$values as $value) {
                $query->orWhere($filter, $value);
            }
        });
        return $query;
    }

    private function where($query, $filter, $values)
    {
        foreach((array)$values as $value) {
            $query->where($filter, $value);
        }
        return $query;
    }
}
