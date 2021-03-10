<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\Between;

use GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class NotBetween extends BaseComparison
{
    use Betweener;

    public $method = 'whereNotBetween';
}
