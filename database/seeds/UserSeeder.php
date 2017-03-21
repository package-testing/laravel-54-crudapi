<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            0 => [ 'name' => 'TestAdmin', 'email' => 'testadmin@example.com', 'password' => '123' ],
            1 => [ 'name' => 'TestUser',  'email' => 'testuser@example.com', 'password' => '123' ],
        ];

        foreach ($users as $u) {
            User::create($u);
        }
    }
}
