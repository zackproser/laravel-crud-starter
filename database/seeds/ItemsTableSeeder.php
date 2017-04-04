<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Populates the items table with our sample data
     *
     * @return void
     */
    public function run()
    {
        $now = date("Y-m-d H:i:s");

        DB::table('items')->insert([
          'name' => 'Robert House',
          'image_url' => 'https://placehold.it/500/375',
          'type' => 'type1',
          'created_at' => $now,
          'updated_at' => $now
        ]);

        DB::table('items')->insert([
          'name' => 'Elizabeth Comstock',
          'image_url' => 'https://placehold.it/500/375',
          'type' => 'type2',
          'created_at' => $now,
          'updated_at' => $now
        ]);

        DB::table('items')->insert([
          'name' => 'Zachary Hale Comstock',
          'image_url' => 'https://placehold.it/500/375',
          'type' => 'type3',
          'created_at' => $now,
          'updated_at' => $now
        ]);

        DB::table('items')->insert([
          'name' => 'Daisy Fitzroy',
          'image_url' => 'https://placehold.it/500/375',
          'type' => 'type1',
          'created_at' => $now,
          'updated_at' => $now
        ]);

        DB::table('items')->insert([
          'name' => 'Booker DeWitt',
          'image_url' => 'https://placehold.it/500/375',
          'type' => 'type2',
          'created_at' => $now,
          'updated_at' => $now
        ]);

        DB::table('items')->insert([
          'name' => 'Rosalind Lutece',
          'image_url' => 'https://placehold.it/500/375',
          'type' => 'type1',
          'created_at' => $now,
          'updated_at' => $now
        ]);
    }
}
