<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

// added by Jonas
use App\Games;

class RankingController extends Controller
{
    public function index()
    {
      $data=[
        'rankings'=> Games::ranking(),
        'matches' => Games::matches()
      ];
      // dd($data);
      return view('visuals.rankings',$data);
    }
}
