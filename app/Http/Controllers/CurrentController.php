<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Games;

class CurrentController extends Controller
{
    public function index()
    {
      $game = Games::orderby('id','desc')->first();
      return View('visuals.score', $data);
    }
}
