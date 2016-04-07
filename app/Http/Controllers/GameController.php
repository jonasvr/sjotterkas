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
use App\Events\MessageSystem;
use Validator;

class GameController extends Controller
{
  protected $game;
  protected $user;
  // protected $MINGOALS = Game::environment('minGoals');
  protected $MINGOALS;
  protected $DIFF;

  public function __construct(Games $game, User $user)
  {
    $this->game = $game;
    $this->user = $user;
    // $this->MINGOALS     = config('game.minGoals');
    $this->MINGOALS     = 3;
    // $this->DIFF         = config('game.diff');
    $this->DIFF         = 1;
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
         event(new MessageSystem('errorMessage', 'Error with creating a new game'));
         return "error";
     }

     $lastGame = $this->game->orderby('id','desc')->first();
     if ($lastGame) {
         if (!$lastGame->points_left && !$lastGame->points_left && !$lastGame->winner ) {
             $this->game->where('id',$lastGame->id)->delete();
         }
     }

      // check if there's a winner or not
      // $game = $this->game->orderby('id','desc')->first();
      $game = $this->game->Latest;
      if ( $game ) {
        if (!$game->winner) {
            if ($game->points_left < $game->points_right) {
              $game->winner = 0;
            }elseif($game->points_left > $game->points_right){
              $game->winner = 1;
            }
          $game->save();
        }
      }

      $game = new Games();
      $game->save();
      event(new NewGame('true'));
      event(new MessageSystem('succesMessage', 'new game created'));
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
         event(new MessageSystem('errorMessage', "error with adding player"));
         echo "error bij speler toevoegen";
         return "error";
     }

      $game = $this->game->Latest;
      $user_id = $this->user->where('card_id',$request->player)->first()->id;
      if ( $game->countPlayers() < 1 ) { // later wordt dit 2 => 4 spelers

        $game->users()->attach($user_id,['is_left' => 1]);
        event(new MessageSystem('succesMessage', "player one is added"));
        echo "player one is added";}
      elseif( $game->countPlayers() < 2 ) { // later wordt dit 4 => 4 spelers

          if ($game->checkPlayer($user_id)) {
              event(new MessageSystem('errorMessage', "this player is already playing"));
              echo "this player is already playing";
          }else {
              $game->users()->attach($user_id,['is_left' => 0]);
              event(new MessageSystem('succesMessage', "all players registrated, let's play"));
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
         event(new MessageSystem('errorMessage', "Error with updating score"));
         echo "error bij actie toevoegen";
         return "error";
     }

      $data = $request->all();
      $game = $this->game->Latest;
    //   $game->winner => boalean => 1 left/ 0 rechts///
      if($game->winner == null)
      {
        if($data['team'] == 'left' && $data['action'] == 'goal') {
          $game->points_left++;
          $goal = new Goals();
          $goal->player_id = $game->getPlayer($game->id, 1);
          // $goal->speed = $data->speed; //update for when sensors arrive
          $goal->save();
          event(new MessageSystem('succesMessage', "left scored!"));
          echo 'left scored';
      }elseif($data['team'] == 'right' && $data['action'] == 'goal')
        {
          $game->points_right++;
          $goal = new Goals();
          $goal->player_id = $game->getPlayer($game->id, 0);
          // $goal->speed = $data->speed; //update for when sensors arrive
          $goal->save();
          event(new MessageSystem('succesMessage', "right scored!"));
          echo 'right scored';
        }
        elseif($data['team'] == 'left' && $data['action'] == 'cancel')
        {
            if ( $game->points_left != 0 ) {
                $game->points_left--;
                //   $goal->speed = $data->speed; //update for when sensors arrive
                  event(new MessageSystem('succesMessage', "left goal canceled"));
                  echo 'left cancel';
            }else {
                event(new MessageSystem('errorMessage', "Can't go under zero"));
            }
      }elseif($data['team'] == 'right' && $data['action'] == 'cancel')
        {
            if ( $game->points_right != 0 ) {
                $game->points_right--;
                //   $goal->speed = $data->speed; //update for when sensors arrive
                  event(new MessageSystem('succesMessage', "right goal canceled"));
                  echo 'right cancel';
            }else {
                event(new MessageSystem('errorMessage', "Can't go under zero"));
            }


        }

        if(($game->points_right >= $this->MINGOALS || $game->points_left >= $this->MINGOALS)
            && abs($game->points_right-$game->points_left) >= $this->DIFF)
        {
          if ($game->points_left < $game->points_right) {
            $game->winner = 0;
            echo  'right wins';
        }elseif($game->points_left > $game->points_right){
            $game->winner = 1;
            echo  'left wins';
          }
          $game->save();
        event(new UpdateWinner($game->Winners->name));
        event(new MessageSystem('succesMessage', $game->Winners->name . " wins"));
        }
        $points_right = $game->points_right;
        $points_left = $game->points_left;
        event(new UpdateScore($points_right,$points_left));
      }
      $game->save();
    }
}
