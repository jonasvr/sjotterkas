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
          if ($game->points_left > $game->points_right) {
            $game->winner = $game->player1;
          }elseif ($game->points_left < $game->points_right) {
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
    //   dd($game);
      $user_id = $this->user->where('card_id',$request->player)->first()->id;
    //   dd($game->countPlayers());
      if ( $game->countPlayers() < 1 ) { // later wordt dit 2 => 4 spelers

        $game->users()->attach($user_id,['is_left' => 1]);
        echo "player one is added";}
      elseif( $game->countPlayers() < 2 ) { // later wordt dit 4 => 4 spelers

          if ($game->checkPlayer($user_id)) {
              echo "this player is already playing";
          }else {
              $game->users()->attach($user_id,['is_left' => 0]);
              echo "play";
          }
      }
      // upgrade to 4players
      $game->save();
      $player1 = $game->getPlayer($game->id, 1);
      $player2 = $game->getPlayer($game->id, 0);
      if( !$player2 ) {
        $player2 = collect([]);
         $player2->name = "player 2";
      }

    //   dd($player1);
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
       'team'   =>  'required',
       'action' =>  'required',
     ]);

     if ($validator->fails()) {

         echo "error bij actie toevoegen";
         return "error";
     }

      $data = $request->all();
      $game = $this->game->getLatest();

      if(!$game->winner)
      {
        if($data['team'] == 'left' && $data['action'] == 'goal') {
          $game->points_left++;
          $goal = new Goals();
          $goal->player_id = $game->getPlayer($game->id, 1);
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'left scored';
      }elseif($data['team'] == 'right' && $data['action'] == 'goal')
        {
          $game->points_right++;
          $goal = new Goals();
          $goal->player_id = $game->getPlayer($game->id, 0);;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'right scored';
        }
        elseif($data['team'] == 'left' && $data['action'] == 'cancel')
        {
          $game->points_left--;
          // $goal->speed = $data->speed; //update for when sensors arrive
          echo 'left cancel';
      }elseif($data['team'] == 'right' && $data['action'] == 'cancel')
        {
          $game->points_right--;
        //   $goal->speed = $data->speed; //update for when sensors arrive
          echo 'right cancel';
        }

        if(($game->points_right >= $this->MINGOALS || $game->points_left >= $this->MINGOALS)
            && abs($game->points_right-$game->points_left) >= $this->DIFF)
        {
          if ($game->points_left > $game->points_right) {
            $game->winner = 1;
            echo  'left wins';
        }elseif($game->points_left < $game->points_right){
            $game->winner = 0;
            echo  'right wins';
          }
        event(new UpdateWinner($game->getWinners()->name));
        }
        $points_right = $game->points_right;
        $points_left = $game->points_left;

        if($goal->save())
        {
          event(new UpdateScore($points_right,$points_left));
        }
      }
      $game->save();
    }
}
