<?php

namespace Camanru\Fastleo;

use Tests\TestCase;

class UrlTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testMain()
    {
        $response = $this->get('/fastleo');
        $response->assertStatus(200);
    }
}
