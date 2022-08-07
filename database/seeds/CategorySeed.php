<?php

use Illuminate\Database\Seeder;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [];

        foreach ($items as $item) {
            \App\Category::create($item);
        }
    }
}
