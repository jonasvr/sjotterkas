<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Games;
use App\Goals;

class GameController extends Controller
{
    public function test()
    {
      echo "in";
      return View('poging.score');
    }


    public function create(Request $request)
    {
    //   $this->validate($request, [
    //    'new' => 'required',
    //  ]);
      $game = new Games();
      $game->save();
      return "ok";
    }
    public function update(Request $request)
    {
      $this->validate($request, [
       'player' => 'required',
     ]);
      $game = Games::orderby('id','desc')->first();
      if (!$game->player1)
      { $game->player1 = $request->player;
      echo "player one is added";}
      elseif(!$game->player2)
      {
        $game->player2 = $request->player;
        echo "game is full, Let's play";
      }
      // upgrade to 4players
      // elseif(!$game->player3)
      // { $game->player3 = 'player3';}
      // elseif(!$game->player4)
      // { $game->player4 = 'player4';}
      else {
        echo "game is full";
      }
      $game->save();
      echo 'player added';
    }

    public function score(Request $request)
    {
      $data = $request->all();
      $game = Games::orderby('id','desc')->first();
      if(!$game->winner)
      {
        if($data['team'] == 'black')
        {
          $game->points_black++;
          $goal = new Goals();
          $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'black scored';
        }elseif($data['team'] == 'green')
        {
          $game->points_green++;
          $goal = new Goals();
          $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'green scored';
        }
        $minGoals=3;
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
        }

        $goal->save();
      }
      $game->save();
    }
}
