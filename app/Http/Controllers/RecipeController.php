<?php

namespace App\Http\Controllers;

use Image;
use App\Tag;
use App\Recipe;
use App\Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RecipeController extends Controller
{
    public function index()
    {
      return view('recipes.index');
    }

    public function fetch()
    {
      return response()->json([
        'recipes' => Recipe::with('user', 'categories', 'tags', 'ingredients', 'likes')->get()
      ]);
    }

    public function get($id)
    {
      $recipe = Recipe::findOrFail($id)->load('user', 'categories', 'tags', 'ingredients', 'likes');

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
        'image' => $recipe->image,
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

      $temp_file_path = public_path().'/images/recipes/'.$recipe->id.'/';
      File::cleanDirectory($temp_file_path);

      if($request->image):
        File::makeDirectory($temp_file_path, $mode = 0777, true, true);
        $image = Image::make($request->image);
        $mime = $image->mime();
        $mime_array = explode('/', $mime);
        $extension = end($mime_array);
        $file_name = str_random(25).'.'.$extension;

        $image->resize(1000, null, function($c){
          $c->aspectRatio();
        })->save($temp_file_path.$file_name);

        $recipe->image = asset('images/recipes/'.$recipe->id.'/'.$file_name);
        $recipe->save();
      endif;

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
      $recipe = Recipe::findOrFail($id)->load('user', 'categories', 'tags', 'ingredients', 'likes');
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

      $temp_file_path = public_path().'/images/recipes/'.$recipe->id.'/';

      if($request->image):
        if($request->image != $recipe->image):
          File::cleanDirectory($temp_file_path);
          File::makeDirectory($temp_file_path, $mode = 0777, true, true);
          $image = Image::make($request->image);
          $mime = $image->mime();
          $mime_array = explode('/', $mime);
          $extension = end($mime_array);
          $file_name = str_random(25).'.'.$extension;

          $image->resize(1000, null, function($c){
            $c->aspectRatio();
          })->save($temp_file_path.$file_name);

          $recipe->image = asset('images/recipes/'.$recipe->id.'/'.$file_name);
          $recipe->save();
        endif;
      else:
        $recipe->image = null;
        $recipe->save();
      endif;

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
        'recipe' => $recipe->load('user', 'categories', 'tags', 'ingredients', 'likes')
      ]);
    }
}
