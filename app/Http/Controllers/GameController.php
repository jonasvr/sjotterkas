<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// added by Jonas
use App\Games;
use App\Goals;
use App\User;

use App\Events\UpdateScore;
use App\Events\UpdatePlayers;
use App\Events\UpdateWinner;
use App\Events\NewGame;
use Validator;

class GameController extends Controller
{
  protected $game;
  protected $user;
  protected $MINGOALS = 1;
  protected $DIFF = 0;

  public function __construct(Games $game, User $user)
  {
    $this->game = $game;
    $this->user = $user;
  }

  /**
   * create a new games
   * checks if there's a past game where the winner has to be determend
   *
   * @param Request $request
   * @return null
   */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new' => 'required',
        ]);

     if ($validator->fails()) {
         echo "error bij aanmaken";
         return "error";
     }

      // check if there's a winner or not
      // $game = $this->game->orderby('id','desc')->first();
      $game = $this->game->getLatest();
      if ( $game ) {
        if (!$game->winner) {
          if ($game->points_black > $game->points_green) {
            $game->winner = $game->player1;
        }elseif ($game->points_black < $game->points_green) {
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

    /**
     * adds a new player
     * checks if all players are filled
     *
     * @param Request $request
     * @return null
     */
    public function update(Request $request)
    {
      $validator = Validator::make($request->all(), [
       'player' =>  'required|size:11',
     ]);

     if ($validator->fails()) {

         echo "error bij speler toevoegen";
         return "error";
     }

      $game = $this->game->getLatest();


      if ( !$game->player1 ) {
         $game->player1 = $request->player;
        $game->users()->attach($request->player,['is_left' => 1]);
      echo "player one is added";}
      elseif( !$game->player2 ) {
          if ($request->player == $game->player1) {
              echo "this player is already playing";
          }else {
              $game->player2 = $request->player;
              $game->users()->attach($request->player,['is_left' => 0]);
              echo "play";
          }
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
    //   dd($game->users()->where('game_id',$game->id)->where('is_left',0)->first());


    //   $player1 = $this->user->where('card_id',$game->player1)->first();
      $player1 = $game->getPlayer($game->id, 1);
      $player2 = $game->getPlayer($game->id, 0);
      if( !$player2 ) {
        $player2 = collect([]);
        $player2->name = "player 2";
      }

      event(new UpdatePlayers($player1->name,$player2->name));

    }

    /**
     * adjust the score (adding or subtracting)
     * determins the winner
     *
     *
     * @param Request $request
     * @return null
     */
    public function score(Request $request)
    {
      $validator = Validator::make($request->all(), [
       'team'   =>  'required|size:5',
       'action' =>  'required',
     ]);

     if ($validator->fails()) {

         echo "error bij actie toevoegen";
         return "error";
     }

      $data = $request->all();
      $game = $this->game->getLatest();

    //   $game = $this->game
    //                 ->orderby('id','desc')
    //                 ->first();

      if(!$game->winner)
      {
        if($data['team'] == 'black' && $data['action'] == 'goal') {
          $game->points_black++;
        //   $goal = new Goals();
        //   $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'black scored';
        }elseif($data['team'] == 'green' && $data['action'] == 'goal')
        {
          $game->points_green++;
        //   $goal = new Goals();
        //   $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'green scored';
        }
        elseif($data['team'] == 'black' && $data['action'] == 'cancel')
        {
          $game->points_black--;
        //   $goal = new Goals();
        //   $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'black cancel';
        }elseif($data['team'] == 'green' && $data['action'] == 'cancel')
        {
          $game->points_green--;
        //   $goal = new Goals();
        //   $goal->player_id = $game->player1;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'green cancel';
        }

        if(($game->points_green >= $this->MINGOALS || $game->points_black >= $this->MINGOALS)
            && abs($game->points_green-$game->points_black) >= $this->DIFF)
        {
          if($game->points_green < $game->points_black)
          {
            $game->winner = $game->player1;
            echo  'black wins';
          }else {
            $game->winner = $game->player2;
            echo  'green wins';
          }
          echo $game->winner;
          $winner = $this->user->where('card_id',$game->winner)->first();
          event(new UpdateWinner($winner->name));
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
