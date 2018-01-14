<?php

use Illuminate\Database\Seeder;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $links = factory(\App\Models\Link::class)->times(6)->make();

        \App\Models\Link::insert($links->toArray());
    }
}
