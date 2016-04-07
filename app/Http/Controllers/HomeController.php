<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// added by Jonas
use App\Games;
use App\User;
use JavaScript;

class HomeController extends Controller
{
    protected $game;
    protected $user;

    public function __construct(Games $game, User $user)
    {
       $this->game = $game;
       $this->user = $user;
    }

    /**
     * gets all the data to be shown for the homescreen
     * current game, winners, most won,...
     *
     *
     * @param Request $request
     * @return view home
     */
    public function index()
    {
        $winner = '';
        $player1 = 'player 1';
        $player2 = 'player 2';

      if ($this->game->Latest) {
        $latest = $this->game->Latest->users()->get();

        if (count($latest)>1) {
            $player1 = $latest[0]->name;
            $player2 = $latest[1]->name;
            if($this->game->Latest->Winners)
            {
                $winner = $this->game->Latest->Winners->name;
            }
          }
      }
    //   dd($this->user->MostWins);
        JavaScript::put([
          'game'    => $this->game->Latest,
          'winner'  => $winner,
          'player1' => $player1,
          'player2' => $player2,
          'wins'    => array_slice($this->user->MostWins, 0, 8, true),
          'matches' => $this->game->Matches,
          'kds'     => array_slice($this->user->KD, 0, 4, true),
        ]);
        return view('home');
    }

}
