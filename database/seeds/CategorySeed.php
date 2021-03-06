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
        $items = [
            
            ['id' => 1, 'name' => 'Senior',],
            ['id' => 2, 'name' => 'Junior',],
            ['id' => 3, 'name' => 'Alumni',],
            ['id' => 4, 'name' => 'Coach',],
        ];

        foreach ($items as $item) {
            \App\Category::create($item);
        }
    }
}
