<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->delete();
        \DB::table('languages')->insert([
            'name' => 'Armenian',
            'code' => 'hy',
        ]);
        \DB::table('languages')->insert([
            'name' => 'English',
            'code' => 'en',
        ]);
    }
}
