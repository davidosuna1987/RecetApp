<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category1 = Category::create([
            'name' => 'Desayuno'
        ]);

        $category2 = Category::create([
            'name' => 'Comida'
        ]);

        $category3 = Category::create([
            'name' => 'Merienda'
        ]);

        $category4 = Category::create([
            'name' => 'Cena'
        ]);

        $category5 = Category::create([
            'name' => 'Entre horas'
        ]);
    }
}
