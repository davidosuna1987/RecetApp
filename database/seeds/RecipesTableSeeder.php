<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Recipe;
use App\Category;
use App\Ingredient;
use App\Tag;

class RecipesTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::findOrFail(1);

        $category = Category::create([
            'name' => 'Desayuno'
        ]);

        $tag1 = Tag::create([
            'name' => 'Tag 1'
        ]);

        $tag2 = Tag::create([
            'name' => 'Tag 2'
        ]);

        $recipe = new Recipe();
        $recipe->name = 'Receta 1';
        $recipe->preparation = 'Preparation';
        $user->recipes()->save($recipe);

        $recipe->categories()->sync([$category->id]);
        $recipe->tags()->sync([$tag1->id, $tag2->id]);

        $ingredient1 = new Ingredient();
        $ingredient1->name = 'Ingredient 1';

        $ingredient2 = new Ingredient();
        $ingredient2->name = 'Ingredient 2';

        $recipe->ingredients()->delete();
        $recipe->ingredients()->saveMany([$ingredient1, $ingredient2]);
    }
}
