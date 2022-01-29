<?php

namespace SearchQuery\FilterQueryString\Tests\Filters\ComparisonClauses;

use SearchQuery\FilterQueryString\Tests\TestCase;

class CombinationTest extends TestCase
{
    /** @test */
    public function unite_two_different_fields_with_greater_and_less()
    {
        $query = 'greater=age,20&less=created_at,2020-12-01';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }
}
