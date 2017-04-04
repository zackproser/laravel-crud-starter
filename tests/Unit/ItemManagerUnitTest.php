<?php

namespace Tests\Unit;

use
    Tests\TestCase,
    Illuminate\Foundation\Testing\WithoutMiddleware,
    Illuminate\Foundation\Testing\DatabaseMigrations,
    Illuminate\Foundation\Testing\DatabaseTransactions
;

class ItemManagerUnitTest extends TestCase
{

   /**
     * Ensure homepage route is working properly
     *
     * @return void
     */
    public function testIndexRoute()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Ensure grid page route is working properly
     *
     * @return void
     */
    public function testGridRoute()
    {
        $response = $this->get('/items');

        $response->assertStatus(200);
    }

    /**
     * Ensure admin route sends HTTP basic auth response
     *
     * @return void
     */
    public function testAdminRoute()
    {
        $response = $this->get('/admin');

        $response->assertStatus(401);
    }
}
