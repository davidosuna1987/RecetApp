<?php

use App\User;
use App\Profile;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create users
        $david = User::create([
            'email' => 'davidosuna1987@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $marc = User::create([
            'email' => 'markpeace@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $esther = User::create([
            'email' => 'esthermaruiz@gmail.com',
            'password' => bcrypt('secret')
        ]);

        $carlos = User::create([
            'email' => 'carlosfaria@gmail.com',
            'password' => bcrypt('secret')
        ]);

        // Create profiles
        $david_profile = new Profile();
        $david_profile->first_name = 'David';
        $david_profile->last_name = 'Osuna Mondaca';
        $david_profile->avatar = null;
        $david_profile->address = 'C/ Bélgica 14, puerta 5';
        $david_profile->city = 'Valencia';
        $david_profile->country = 'España';

        $david->profile()->save($david_profile);

        $marc_profile = new Profile();
        $marc_profile->first_name = 'Marc';
        $marc_profile->last_name = 'Paz Mateu';

        $marc->profile()->save($marc_profile);

        $esther_profile = new Profile();
        $esther_profile->first_name = 'Esther';
        $esther_profile->last_name = 'Martínez Martínez';

        $esther->profile()->save($esther_profile);

        $carlos_profile = new Profile();
        $carlos_profile->first_name = 'Carlos';
        $carlos_profile->last_name = 'Faria Supermundano';

        $carlos->profile()->save($carlos_profile);
    }
}
