<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AddUserRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {--email=null} {--user=null} {--role=null}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a predefined role to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = $this->options();

        // User To Assign
        $user = $this->getUser($options);
        $role = $this->getRole($options);

        if ($user === false) {
            return $this->line('Unable to find user');
        }
        if ($role === false) {
            return $this->line('Unable to find role');
        }

        // Create the UserRole.
        try {
            UserRole::create(['user_id' => $user->id, 'role_id' => $role->id]);
        } catch (Exception $e) {
            \Log::debug($e->getMessage());
            $this->line("Unable to add user to role");
        }
        /* Get list of roles */
        $this->line("User {$user->name} added to {$role->name} role.");
    }

    public function buildUserTable($users)
    {
        $user_data = [];
        foreach ($users as $user) {
            $user_data[] = [$user->id, $user->forename . ' ' . $user->surname];
        }
        return $user_data;
    }

    public function getRole($options)
    {
        if (!array_key_exists('role', $options)) {
            return false;
        }
        $role = $options['role'];

        if ($role == 'null' || $role == null) {
            return $this->promptForRole();
        }

        $length = strlen($role);

        if ($length > 2) {
            // String
            $role_name = $role;
            $query = Role::where('name', $role_name);
        } else {
            // Integer
            $role_id = $role;
            $query = Role::where('id', $role_id);
        }

        try {
            $role = $query->firstOrFail();
            return $role;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function getUser($options)
    {
        // Attempt to get by email
        if (array_key_exists('email', $options)) {
            $email = $options['email'];
            $user = $this->getUserByEmail($email);

            if ($user !== false) {
                return $user;
            }
        }

        // Attempt to get by user
        if (array_key_exists('user', $options)) {
            $user_id = $options['user'];
            $user = $this->getUserById($user_id);

            if ($user !== false) {
                return $user;
            }
        }

        // Prompt for the user
        return $this->promptForUser();
    }

    private function getUserByEmail($email)
    {
        try {
            $user = User::where('email', $email)->firstOrFail();
            return $user;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    private function getUserById($id)
    {
        try {
            $user = User::where('id', $id)->firstOrFail();
            return $user;
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }

    public function promptForUser()
    {
        /* Get list of users */
        $users = User::all();
        $userData = $this->buildUserTable($users);
        $this->table(['id', 'username'], $userData);
        $user_id = $this->ask('Which user would you like to assign a role for? [1,2,...]');
        if ($user_id == 0) { return false; }
        $user = User::where('id', (int)$user_id)->first();
        return $user;
    }

    /**
     * Get the role id from input.
     * @return string $role_id
     */
    public function promptForRole()
    {
        $roles = Role::all();
        $roleData = $this->buildRoleTable($roles);
        $this->table(['id', 'role'], $roleData);
        $role_id = $this->ask('Which role would you like to assign to the user? [1,2,...]');
        if ($role_id == 0) { return false; }
        $role = Role::where('id', (int)$role_id)->first();
        return $role;
    }

    /**
     * Build Roles table.
     * @param \Illuminate\Database\Eloquent\Collection $roles
     * @return array
     */
    public function buildRoleTable($roles)
    {
        $role_data = [];
        foreach ($roles as $r) {
            $role_data[] = [$r->id, $r->name];
        }
        return $role_data;
    }
}
