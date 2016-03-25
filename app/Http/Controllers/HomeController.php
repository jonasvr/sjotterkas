<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// added by Jonas
use App\Games;
use JavaScript;

class HomeController extends Controller
{
    protected $game;

    public function __construct(Games $game)
    {
      $this->game = $game;
    }

    public function index()
    {
      if ($this->game->getLatest()) {
        $latest = $this->game->getLatest()->users()->get();
        if ($latest[1]->name) {
            $player1 = $latest[0]->name;
            $player2 = $latest[1]->name;
          }else {
            $player1 = 'player1';
            $player2 = 'player2';
            }
      }else {
        $player1 = 'player1';
        $player2 = 'player2';
        }


    // dd( $latest[0]->name);
    //   dd( $this->game->users()->where('game_id', $latest)->get());


        // dd($this->game->matches()->toArray());
        JavaScript::put([
          'rankings'=> $this->game->ranking()->toArray(),
          'matches' => $this->game->matches()->toArray(),
          'game'    => $this->game->getLatest(),
          'player1' => $player1,
          'player2' => $player2,
        ]);
        return view('home');
    }
}
