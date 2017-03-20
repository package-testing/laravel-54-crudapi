<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class NonAdminCrudApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVisitingRolesAsNonAdminRedirectsHome()
    {
        $response = $this->get('/admin/Role')
             ->assertSee('Laravel');
    }
}