<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        $items = [['id' => 1,'language' => 'English', 'locale' => 'en']];

        foreach ($items as $item) {
            \App\Language::create($item);
        }
    }
}
