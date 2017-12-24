<?php

use Illuminate\Database\Seeder;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_ids = \App\Models\User::all()->pluck('id')->toArray();

        $categories_ids = \App\Moldes\Category::all()->pluck('id')->toArray();

        $faker = app(Faker\Generator::class);

        $topics = factory(\App\Models\Topics::class)
                ->times(100)
                ->make()
                ->each(function($topic,$index) use($faker,$user_ids,$categories_ids){
                    $topic->user_id = $faker->randomElement($user_ids);
                    $topic->category_id = $faker->randomElement($categories_ids);
                });

        \App\Models\Topics::insert($topics->toArray());
    }
}
