<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ScoreController extends Controller
{
    public function test()
    {
      echo "in";
      return View('poging.score');
    }
    public function score(Request $request)
    {
      $data = $request->all();

      echo $data['team'];
    }
}
