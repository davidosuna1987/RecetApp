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

    public function get($id)
    {
      $recipe = Recipe::findOrFail($id)->load('categories', 'tags', 'ingredients');

      $tags = [];
      $categories = [];
      $ingredients = [];

      foreach($recipe->tags as $tag):
        $tags[] = $tag->name;
      endforeach;

      foreach($recipe->categories as $category):
        $categories[] = $category->id;
      endforeach;

      foreach($recipe->ingredients as $ingredient):
        $ingredients[] = $ingredient->name;
      endforeach;

      return response()->json([
        'id' => $recipe->id,
        'title' => $recipe->title,
        'preparation' => $recipe->preparation,
        'tags' => $tags,
        'categories' => $categories,
        'ingredients' => $ingredients
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

      $recipe->categories()->detach();
      $recipe->categories()->attach($request->categories);

      $recipe->tags()->detach();
      if(count($tags))
        $recipe->tags()->attach($tags);

      $ingredients = [];
      foreach($request->ingredients as $ingredient):
        $i = Ingredient::where('name', $ingredient)->first();

        if(!$i)
          $i = Ingredient::create(['name' => $ingredient]);

        $ingredients[] = $i->id;
      endforeach;

      $recipe->ingredients()->detach();
      $recipe->ingredients()->attach($ingredients);

      return response()->json([
        'recipe' => $recipe->load('categories', 'tags', 'ingredients')
      ]);
    }

    public function show($id)
    {
      $recipe = Recipe::findOrFail($id)->load('categories', 'tags', 'ingredients');
      dump($recipe);
    }

    public function edit($id)
    {
      $recipe = Recipe::findOrFail($id);

      return view('recipes.edit', compact('recipe'));
    }

    public function update(Request $request)
    {
      $tags = [];
      foreach($request->tags as $tag):
        $t = Tag::where('name', $tag)->first();

        if(!$t)
          $t = Tag::create(['name' => $tag]);

        $tags[] = $t->id;
      endforeach;

      $recipe = Recipe::findOrFail($request->id);
      $recipe->title = $request->title;
      $recipe->preparation = $request->preparation;
      $recipe->save();

      $recipe->categories()->detach();
      $recipe->categories()->attach($request->categories);

      $recipe->tags()->detach();
      if(count($tags))
        $recipe->tags()->attach($tags);

      $ingredients = [];
      foreach($request->ingredients as $ingredient):
        $i = Ingredient::where('name', $ingredient)->first();

        if(!$i)
          $i = Ingredient::create(['name' => $ingredient]);

        $ingredients[] = $i->id;
      endforeach;

      $recipe->ingredients()->detach();
      $recipe->ingredients()->attach($ingredients);

      return response()->json([
        'recipe' => $recipe->load('categories', 'tags', 'ingredients')
      ]);
    }
}
