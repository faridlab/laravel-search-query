<?php

namespace SearchQuery\FilterQueryString\Tests;

use SearchQuery\FilterQueryString\Models\User;

class CustomFilterTest extends TestCase
{
    /** @test */
    public function young_custom_method()
    {
        $query = 'young=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);

        $query = 'young=0';

        $response = $this->get("/?$query");

        $response->assertJsonCount(User::count());
    }

    /** @test */
    public function young_and_old_custom_method()
    {
        $query = 'young=1&old=1';

        $response = $this->get("/?$query");

        $response->assertJsonCount(0);
    }

    /** @test */
    public function young_custom_method_and_in()
    {
        $query = 'young=0&in=name,mehrad';

        $response = $this->get("/?$query");

        $response->assertJsonCount(1);
    }
}
