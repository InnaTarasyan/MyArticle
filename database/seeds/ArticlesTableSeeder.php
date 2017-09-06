<?php

use Illuminate\Database\Seeder;

class ArticlesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles')->insert([
            'title' => str_random(5),
            'description' => str_random(10),
            'main_image' => str_random(5).'png',
            'data' => date("Y-m-d H:i:s"),
            'url' => 'http'.str_random(5).'.com'
        ]);
    }
}
