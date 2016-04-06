<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

// added by Jonas
use App\Games;
use App\User;

class RankingController extends Controller
{
    protected $game;
    protected $user;

    public function __construct(Games $game, User $user)
    {
       $this->game = $game;
       $this->user = $user;
    }


    public function index()
    {
      $data=[
          'wins'            => $this->user->MostWins,
          'losses'          => $this->user->MostLosses,
          'percentage'      => $this->user->Percentage,
          'matches'         => $this->game->matches()->toArray(),
          'kds'             => $this->user->KD,
      ];

    //   dd($data);

      return view('visuals.rankings', $data);
    }
}
