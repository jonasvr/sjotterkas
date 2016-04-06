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
        $player1 = 'player1';
        $player2 = 'player2';

      if ($this->game->getLatest()) {
        $latest = $this->game->getLatest()->users()->get();

        if (count($latest)>1) {
            $player1 = $latest[0]->name;
            $player2 = $latest[1]->name;
            if($this->game->getLatest()->getWinners())
            {
                $winner = $this->game->getLatest()->getWinners()->name;
            }
          }
      }
    //   dd($this->user->MostWins);
        JavaScript::put([
          'game'    => $this->game->getLatest(),
          'winner'  => $winner,
          'player1' => $player1,
          'player2' => $player2,
          'wins'    => $this->user->MostWins,
          'matches' => $this->game->matches()->toArray(),
          'kds'     => $this->user->KD,
        ]);
        return view('home');
    }

    public function killDeathRatio()
    {
        $test=$this->user->kdRatio();
    }
}
