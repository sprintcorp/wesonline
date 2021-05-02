<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'Siwes Cordinator'],
            ['id' => 3, 'name' => 'Siwes Supervisor'],            
            ['id' => 4, 'name' => 'Student'],
            ['id' => 5, 'name' => 'Employer'],
            ['id' => 6, 'name' => 'Employee'],
            ['id' => 7, 'name' => 'ITF'],
            ['id' => 8, 'name' => 'System'],
            
        ];
        foreach($roles as $role){
            Role::create($role);
        }
    }
}
