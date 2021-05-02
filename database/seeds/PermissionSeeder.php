<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'name' => 'Create student'],
            ['id' => 2, 'name' => 'Edit student'],
            ['id' => 3, 'name' => 'Archive student'],            
            ['id' => 4, 'name' => 'Create course and assessment'],
            ['id' => 5, 'name' => 'Edit course and assessment'],
            ['id' => 6, 'name' => 'View student assessment'],
            ['id' => 7, 'name' => 'Comment on log book'],
            ['id' => 8, 'name' => 'Create group'],
            ['id' => 9, 'name' => 'Assign student to group'],
            ['id' => 10, 'name' => 'Remove student from group'],
            ['id' => 11, 'name' => 'View interns'],            
            ['id' => 12, 'name' => 'View intership request'],
            ['id' => 13, 'name' => 'Create webinars'],
            ['id' => 14, 'name' => 'Edit webinars'],
            ['id' => 15, 'name' => 'Delete webinars'],
            ['id' => 16, 'name' => 'View participant'],
            ['id' => 17, 'name' => 'Create employees'],
            ['id' => 18, 'name' => 'Edit employees'],
            ['id' => 19, 'name' => 'Disable employee'],
            ['id' => 20, 'name' => 'Add/Remove staff from group'],            
            
            
        ];
        foreach($roles as $role){
            Permission::create($role);
        }
    }
}
