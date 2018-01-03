<?php

use Illuminate\Database\Seeder;

class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        $user_ids = \App\Models\User::all()->pluck('id')->toArray();

        $topic_ids = \App\Models\Topics::all()->pluck('id')->toArray();

        $replys = factory(\App\Models\Reply::class)
                    ->times(1000)
                    ->make()
                    ->each(function ($reply,$index)
                            use($user_ids,$topic_ids,$faker){
                        $reply->user_id = $faker->randomElement($user_ids);
                        $reply->topic_id = $faker->randomElement($topic_ids);
                    });

        \App\Models\Reply::insert($replys->toArray());
    }
}
