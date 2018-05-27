<?php

use App\Tag;
use App\User;
use App\Recipe;
use App\Category;
use App\Ingredient;
use Illuminate\Database\Seeder;

class RecipesTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::findOrFail(1);

        $tag1 = Tag::create([
            'name' => 'Tag 1'
        ]);

        $tag2 = Tag::create([
            'name' => 'Tag 2'
        ]);

        $recipe = new Recipe();
        $recipe->title = 'Receta 1';
        $recipe->preparation = 'Preparation';
        $user->recipes()->save($recipe);

        $recipe->categories()->sync([1, 2, 3, 4, 5]); // Previously created on CategoriesTableSeeder::class
        $recipe->tags()->sync([$tag1->id, $tag2->id]);

        $ingredient1 = Ingredient::create([
            'name' => 'Ingredient 1'
        ]);

        $ingredient2 = Ingredient::create([
            'name' => 'Ingredient 2'
        ]);

        $recipe->ingredients()->sync([$ingredient1->id, $ingredient2->id]);
    }
}
