<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class CrudApiAdminTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testVisitingAdminRolesAsAnAdminShowsTheCrudApi()
    {
        $user = User::where('email', 'testadmin@example.com')->first();

        $this->actingAs($user)
            ->get('admin/Role')
            ->assertSee('Roles')
            ->assertSee('Name')
            ->assertSee('Administrator')
            ->assertSee('Actions')
            ->assertSee('Create Role')
            ->assertSee('Edit');
    }
}
