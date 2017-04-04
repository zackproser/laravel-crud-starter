<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Populates the admins table with our demo user
     *
     * This admin user will have access to the /admin panel for CRUD operations on the items resource
     *
     * Need to create several more admin users? Follow the pattern established below to add whichever accounts you want.
     *
     * @return void
     */
    public function run()
    {

      DB::table('users')->insert([
        'name' => 'Laravel CRUD Starter Admin User',
        'email' => env('ADMIN_EMAIL'), //Defined in your .env file
        'password' => Hash::make(env('ADMIN_PASSWORD')) //Hash password using Bcrypt - defined in your .env file
      ]);
    }
}
