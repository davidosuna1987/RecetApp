<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle(Request $request)
    {
      $like = Like::where(['user_id' => $request->user_id, 'recipe_id' => $request->recipe_id])->first();

      if($like):
        $like->delete();
        return response()->json(['like' => $like, 'action' => 'unlike']);
      else:
        $like = Like::create(['user_id' => $request->user_id, 'recipe_id' => $request->recipe_id]);
        return response()->json(['like' => $like, 'action' => 'like']);
      endif;
    }
}
