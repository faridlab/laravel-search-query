<?php

namespace SearchQuery\FilterQueryString\Filters;

use SearchQuery\FilterQueryString\Filters\ComparisonClauses\{
    EqualClause,
    GreaterThanClause,
    GreaterThanEqualClause,
    LessThanClause,
    LessThanEqualClause,
    NotEqualClause
};

use SearchQuery\FilterQueryString\Filters\LikeClauses\{
    WhereLikeClause,
    WhereNotLikeClause,
    WhereContainClause,
    WhereNotContainClause,
    WhereStartWithClause,
    WhereEndWithClause,
};

use SearchQuery\FilterQueryString\Filters\BetweenClauses\{
    WhereBetweenClause,
    WhereNotBetweenClause,
    WhereInClause,
    WhereNotInClause
};

use SearchQuery\FilterQueryString\Filters\NullClauses\{
    WhereNullClause,
    WhereNotNullClause
};

use Illuminate\Database\Eloquent\Builder;

class WhereClause extends BaseClause {
    use EqualClause;
    use NotEqualClause;
    use GreaterThanClause;
    use GreaterThanEqualClause;
    use LessThanClause;
    use LessThanEqualClause;

    use WhereLikeClause;
    use WhereNotLikeClause;
    use WhereContainClause;
    use WhereNotContainClause;
    use WhereStartWithClause;
    use WhereEndWithClause;

    use WhereBetweenClause;
    use WhereNotBetweenClause;
    use WhereInClause;
    use WhereNotInClause;

    use WhereNullClause;
    use WhereNotNullClause;

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
        'notcontain' => 'notContain',
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
