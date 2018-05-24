<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create users
        User::create([
            'email' => 'davidosuna1987@gmail.com',
            'name' => 'David Osuna Mondaca',
            'password' => bcrypt('secret')
        ]);

        User::create([
            'email' => 'markpeace@gmail.com',
            'name' => 'Marc Paz Mateu',
            'password' => bcrypt('secret')
        ]);
    }
}
