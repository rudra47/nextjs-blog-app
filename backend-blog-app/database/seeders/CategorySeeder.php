<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            0 => [
                'id' => 1,
                'name' => 'Oral'
            ],
            1 => [
                'id' => 1,
                'name' => 'Injectable'
            ],
            2 => [
                'id' => 1,
                'name' => 'Peptides'
            ],
            3 => [
                'id' => 1,
                'name' => 'Blends'
            ],
            4 => [
                'id' => 1,
                'name' => 'Potency'
            ],
            5 => [
                'id' => 1,
                'name' => 'Popular'
            ],
            6 => [
                'id' => 1,
                'name' => 'More'
            ],
            7 => [
                'id' => 1,
                'name' => 'Goldline'
            ],
            8 => [
                'id' => 1,
                'name' => 'Hormones'
            ],
            9 => [
                'id' => 1,
                'name' => 'Antiestrogen'
            ],
            10 => [
                'id' => 1,
                'name' => 'Popularoral'
            ],
            11 => [
                'id' => 1,
                'name' => 'Moreoral'
            ],
            12 => [
                'id' => 1,
                'name' => 'Morepeptides'
            ],
            13 => [
                'id' => 1,
                'name' => 'Hcg'
            ],
            14 => [
                'id' => 1,
                'name' => 'Hgh'
            ],
            15 => [
                'id' => 1,
                'name' => 'hide'
            ],
            16 => [
                'id' => 1,
                'name' => 'MIGLYOL840'
            ],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        foreach ($categories as $key => $category) {
            $category = \App\Models\Category::create([
                'name' => $category['name'],
                'slug' =>  Str::slug($category['name']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
