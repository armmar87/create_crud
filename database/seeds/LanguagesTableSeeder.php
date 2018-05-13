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

        foreach (config('languages') as $lang){
            \DB::table('languages')->insert([
                'name' => $lang['name'],
                'code' => $lang['code'],
            ]);
        }

    }
}
