<?php

use CivicApp\Models\PostType;
use Illuminate\Database\Seeder;

class PostTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PostType::create([
            'post_type'=>'Generico',
        ]);

    }
}
