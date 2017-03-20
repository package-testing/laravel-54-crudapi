<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;

class ModelWithoutPolicyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAccessingModelWithoutPolicyRedirectsHome()
    {
        $user = User::where('email', 'testadmin@example.com')->first();

        // Even as an admin
        $this->actingAs($user)
            // When I go to /admin/model
            // For a model without a policy
            ->get('/admin/Organisation')
            // I will be redirected to the app home page.
            ->assertRedirect('/');
    }
}
