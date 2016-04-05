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
      if ($this->game->getLatest()) {
        $latest = $this->game->getLatest()->users()->get();

        if (count($latest)>1) {
            $player1 = $latest[0]->name;
            $player2 = $latest[1]->name;
            // dd($winner = $this->game->getLatest()->getWinner()->first());
            if($this->game->getLatest()->getWinner()->first())
            {$winner = $this->game->getLatest()->getWinner()->first()->name;}
          }else {
            $player1 = 'player1';
            $player2 = 'player2';
            }
      }else {
        $player1 = 'player1';
        $player2 = 'player2';
        }

        JavaScript::put([
          'rankings'=> $this->game->ranking()->toArray(),
          'matches' => $this->game->matches()->toArray(),
          'game'    => $this->game->getLatest(),
          'winner'  => $winner,
          'player1' => $player1,
          'player2' => $player2,
        ]);
        return view('home');
    }

    public function killDeathRatio()
    {
        $test=$this->user->kdRatio();
    }
}
