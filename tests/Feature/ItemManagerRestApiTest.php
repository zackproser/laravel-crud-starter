<?php

namespace Tests\Feature;

use
    Tests\TestCase,
    \App\Item,
    Illuminate\Support\Facades\DB,
    Illuminate\Foundation\Testing\WithoutMiddleware,
    Illuminate\Foundation\Testing\DatabaseMigrations,
    Illuminate\Foundation\Testing\DatabaseTransactions,
    Illuminate\Foundation\Testing\InteractsWithDatabase
;

class ItemManagerRestApiTest extends TestCase
{

    /**
     * Ensure a request to the backend that only includes one of several
     * required fields is rejected with validation errors
     *
     * @return void
     */
    public function testItemAPIValidation()
    {
        //Make a request to the backend, passing only the item name, which is invalid
        //Specify the X-Requested-With header to mimic an AJAX request
        $response = $this->post('/api/candidates',
            ['name' => 'Booker DeWitt'],
            ['X-Requested-With' => 'XMLHttpRequest']);

        //Ensure backend API returns validation errors, signified by HTTP code 422
        $response->assertStatus(422);
    }

    /**
     * Make a POST request to the API, passing a valid item object
     *
     * @return void
     */
    public function testItemAPICreate()
    {
        //Make a request to the backend, with valid item data
        //Specify the X-Requested-With header to mimic an AJAX request
        $response = $this->post('/api/items',
            ['name' => 'Robert Lutece',
             'image_url' => 'https://www.placehold.it/500/500',
             'type' => 'type1'
            ],
            ['X-Requested-With' => 'XMLHttpRequest']
        );

        $response->assertStatus(200);

        //Ensure item record was persisted to the database correctly
        $this->assertDatabaseHas('items', ['name' => 'Robert Lutece']);
    }
}
