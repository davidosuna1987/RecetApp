<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Recipe;
use App\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function index()
    {
      return response()->json([
        'recipes' => Recipe::with('categories', 'tags', 'ingredients')->get()
      ]);
    }

    public function create()
    {
      return view('recipes.create');
    }

    public function store(Request $request)
    {
      $tags = [];
      foreach($request->tags as $tag):
        $t = Tag::where('name', $tag)->first();

        if(!$t)
          $t = Tag::create(['name' => $tag]);

        $tags[] = $t->id;
      endforeach;

      $recipe = new Recipe();
      $recipe->title = $request->title;
      $recipe->preparation = $request->preparation;
      Auth::user()->recipes()->save($recipe);

      $recipe->categories()->sync($request->categories);
      if(count($tags))
        $recipe->tags()->sync($tags);

      $ingredients = [];
      foreach($request->ingredients as $ingredient):
        $i = Ingredient::where('name', $ingredient)->first();

        if(!$i):
          $i = new Ingredient();
          $i->name = $ingredient;
        endif;

        $ingredients[] = $i;
      endforeach;

      $recipe->ingredients()->saveMany($ingredients);

      return response()->json([
        'recipe' => $recipe->load('categories', 'tags', 'ingredients')
      ]);
    }

    public function show($id)
    {
      $recipe = Recipe::findOrFail($id)->load('categories', 'tags', 'ingredients');
      dump($recipe);
    }
}
