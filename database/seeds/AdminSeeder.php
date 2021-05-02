<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = ['email'=>'sprintcorp7@gmail.com','password'=>Hash::make('qwertyuiop'),'role_id'=>8];
        User::create($user);
    }
}
