<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
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

        User::create([
            'email' => 'esthermaruiz@gmail.com',
            'name' => 'Esther Martínez Martínez',
            'password' => bcrypt('secret')
        ]);

        User::create([
            'email' => 'carlosfaria@gmail.com',
            'name' => 'Carlos Faria Supermundano',
            'password' => bcrypt('secret')
        ]);
    }
}
