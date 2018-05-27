<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;

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
      dd($request->all());
    }
}
