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
    //   dd($this->game->getLatest() ->with('users')->get());
    //   $test = Games::with('users')->get();
    //   foreach ($test as $user) {
    //       echo ( $user->users[0]->pivot->is_left);
    //   }
    //   dd(Games::with('users')->get());
    //   dd(User::with('games')->get());
//     //   var_dump(User::orderBy('id', 'desc')->first()->games());
// dd();
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
