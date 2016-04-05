<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Events\NewCard;
use Validator;

class CardController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
      $this->user = $user;
    }

    /**
     * Add a new card to the database
     * Checks for card without a user & deletes them
     *
     * @param Request $request
     * @return null
     */
    public function addCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'card_id' => 'required|size:11',
                'body'    => 'required',
            ]);

            if ($validator->fails()) {
                echo "error";
            }

        $data = $request->all();
        $this->user->where('name', null)->delete();
        $user = $this->user->first();
        if($user)
        {
          $user = $this->user->where('card_id',  $data['card_id'])->first();
        }

        if ( !$user ) {
          $this->user->create([
              'card_id' => $data['card_id'],
          ]);
          echo "added";
          event(new NewCard($data['card_id']));
        } else {
          echo "card is already used";
        }
      }

      /**
       * Adds a new User to the empty card
       *
       * @param Request $request
       * @return null
       */
      public function addName(Request $request)
      {
          $user = $this->user->orderby('id','desc')->first();
          if ( !$user->name)
          {
            $user->name = $request->name;
            $user->save();
          }
          return back()->withsucces('succes');
       }
}
