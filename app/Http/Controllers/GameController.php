<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// added by Jonas
use App\Games;
use App\Goals;

use App\Events\UpdateScore;
use App\Events\UpdatePlayers;
use App\Events\UpdateWinner;
use App\Events\NewGame;

class GameController extends Controller
{
  protected $game;

  public function __construct(Games $game)
  {
    $this->game = $game;
  }

    public function index()
    {
      $game = Games::orderby('id','desc')->first();
      $data = [
        "game" => $game,
      ];

      return View('visuals.score', $data);
    }


    public function create(Request $request)
    {
    //   $this->validate($request, [
    //    'new' => 'required',
    //  ]);

      // check if there's a winner or not
      $game = Games::orderby('id','desc')->first();
      if ( $game ) {
        if (!$game->winner) {
          $game->winner = 'Tie';
          if ($game->points_black > $game->points_green) {
            $game->winner = $game->player1;
          }else {
            $game->winner = $game->player2;
          }
          $game->save();
        }
      }


      $game = new Games();
      $game->save();
      event(new NewGame('true'));

      echo "new";
    }

    public function update(Request $request)
    {
      $this->validate($request, [
       'player' => 'required',
     ]);
      $game = Games::orderby('id','desc')->first();
      if ( !$game->player1 ) {
        $game->player1 = $request->player;
      echo "player one is added";}
      elseif( !$game->player2 ) {
        $game->player2 = $request->player;

        echo "play";
      }
      // upgrade to 4players
      // elseif(!$game->player3)
      // { $game->player3 = 'player3';}
      // elseif(!$game->player4)
      // { $game->player4 = 'player4';}
      else {
        echo "game is full";
      }
      event(new UpdatePlayers($game->player1,$game->player2));
      $game->save();
    }

    public function score(Request $request)
    {
      $data = $request->all();
      $game = Games::orderby('id','desc')->first();
      if(!$game->winner)
      {
        if($data['team'] == 'black' && $data['action'] == 'goal') {
          $game->points_black++;
          $goal = new Goals();
          $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'black scored';
        }elseif($data['team'] == 'green' && $data['action'] == 'goal')
        {
          $game->points_green++;
          $goal = new Goals();
          $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'green scored';
        }
        elseif($data['team'] == 'black' && $data['action'] == 'cancel')
        {
          $game->points_black--;
          $goal = new Goals();
          $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'black cancel';
        }elseif($data['team'] == 'green' && $data['action'] == 'cancel')
        {
          $game->points_green--;
          $goal = new Goals();
          $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'green cancel';
        }

        $minGoals=11;
        $diff = 2;
        if(($game->points_green >= $minGoals || $game->points_black >= $minGoals) && abs($game->points_green-$game->points_black) >= $diff)
        {
          if($game->points_green < $game->points_black)
          {
            $game->winner = $game->player1;
            echo  'black wins';
          }else {
            $game->winner = $game->player2;
            echo  'green wins';
          }
          event(new UpdateWinner($game->winner));
        }
        $points_green = $game->points_green;
        $points_black = $game->points_black;

        if($goal->save())
        {
          event(new UpdateScore($points_green,$points_black));
        }
      }
      $game->save();
    }
}
