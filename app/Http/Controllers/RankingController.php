<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

// added by Jonas
use App\Games;
use App\User;
use JavaScript;

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
          'matches'         => $this->game->Matches,
          'kds'             => $this->user->KD,
      ];

      JavaScript::put([
        'percentage'    => $this->user->Percentage,
        'losses'        => $this->user->MostLosses,
        'wins'          => $this->user->MostWins,
        'matches'       => $this->game->Matches,
        'kds'           => $this->user->KD,

      ]);

    //   dd($data);

      return view('visuals.rankings', $data);
    }
}
