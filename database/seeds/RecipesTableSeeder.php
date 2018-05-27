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

        $recipe = Recipe::create([
            'user_id' => $user->id,
            'name' => 'Receta 1',
            'preparation' => 'Preparation'
        ]);

        $recipe->categories()->sync([$category->id]);
        $recipe->tags()->sync([$tag1->id, $tag2->id]);

        $ingredient1 = Ingredient::create([
            'recipe_id' => $recipe->id,
            'name' => 'Ingredient 1'
        ]);

        $ingredient2 = Ingredient::create([
            'recipe_id' => $recipe->id,
            'name' => 'Ingredient 2'
        ]);

        $recipe->ingredients()->delete();
        $recipe->ingredients()->saveMany([$ingredient1, $ingredient2]);
    }
}
