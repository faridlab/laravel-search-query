<?php

namespace GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\Between;

use GrammaticalQuery\FilterQueryString\Filters\ComparisonClauses\BaseComparison;

class Between extends BaseComparison
{
    use Betweener;

    public $method = 'whereBetween';
}
