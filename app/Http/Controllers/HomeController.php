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

    public function index() {
    if ($this->game->getLatest() && $this->game->getLatest()->player2) {
        $player1 = $this->game->getLatest()->getPlayer1->name;
        $player2 = $this->game->getLatest()->getPlayer2->name;
      }else {
      $player1 = 'player1';
      $player2 = 'player2';
      }

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
