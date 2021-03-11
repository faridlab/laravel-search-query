<?php

namespace GrammaticalQuery\FilterQueryString;

use Illuminate\Pipeline\Pipeline;
use GrammaticalQuery\FilterQueryString\Filters\{
    OrderbyClause,
    SelectClause,
    LimitClause,
    SearchClause,
    RelationshipClause,
    WithTrashedClause,
    OrderClause,
    WhereClause,
    WhereInClause,
    WhereLikeClause
};
use GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\{GreaterOrEqualTo, GreaterThan, LessOrEqualTo, LessThan};
use GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\Between\{Between, NotBetween};

trait FilterQueryString {

    use Resolvings;

    private $availableFilters = [
        'default' => WhereClause::class,
        'search' => SearchClause::class,
        'fields' => SelectClause::class,
        'limit' => LimitClause::class,
        'page' => LimitClause::class,
        'relationship' => RelationshipClause::class,
        'withtrashed' => WithTrashedClause::class,
        'orderby' => OrderClause::class,

        'sort' => OrderbyClause::class,
        'greater' => GreaterThan::class,
        'greater_or_equal' => GreaterOrEqualTo::class,
        'less' => LessThan::class,
        'less_or_equal' => LessOrEqualTo::class,
        'between' => Between::class,
        'not_between' => NotBetween::class,
        'in' => WhereInClause::class,
        'like' => WhereLikeClause::class,
    ];

    public function scopeFilter($query, ...$filters)
    {
        $filters = collect($this->getFilters($filters))->map(function ($values, $filter) {
            return $this->resolve($filter, $values);
        })->toArray();

        if(!isset($filters['limit'])) {
            $filters['limit'] = $this->resolve('limit', 25);
        }

        if(!isset($filters['page'])) {
            $filters['page'] = $this->resolve('page', 1);
        }

        return app(Pipeline::class)
        ->send($query)
        ->through($filters)
        ->thenReturn();
    }

    private function getFilters($filters)
    {
        $filter = function ($key) use($filters) {

            $filters = $filters ?: $this->filters ?: [];

            return $this->unguardFilters != true ? in_array($key, $filters) : true;
        };

        return array_filter(request()->query(), $filter, ARRAY_FILTER_USE_KEY) ?? [];
    }
}
