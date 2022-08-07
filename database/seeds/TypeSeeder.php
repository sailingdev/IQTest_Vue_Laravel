<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $items = [

            ['id' => 1, 'name' => 'Exam', 'description'  =>  'Exam'],
            ['id' => 2, 'name' => 'Assessment(Signle Factor)', 'description'  =>  'Assessment(Signle Factor)'],
            ['id' => 3, 'name' => 'Assessment(Multi Factors)', 'description'  =>  'Assessment(Multi Factors)'],

        ];
        foreach ($items as $item) {
            \App\Type::create($item);
        }
    }
}