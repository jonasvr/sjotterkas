<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

// added by Jonas
use App\Games;

class RankingController extends Controller
{
    protected $game;

    public function __construct(Games $game)
    {
      $this->game = $game;
    }

    public function index()
    {
      $data=[
        'rankings'=> $this->game->ranking(),
        'matches' => $this->game->matches()
      ];

      return view('visuals.rankings',$data);
    }
}
