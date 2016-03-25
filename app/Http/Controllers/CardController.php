<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Events\NewCard;
use Validator;

class CardController extends Controller
{
  public function addCard(Request $request)
  {
    $validator = Validator::make($request->all(), [
            'card_id' => 'required|size:11',
            'body' => 'required',
        ]);

        if ($validator->fails()) {
            echo "error";
        }

    $data = $request->all();
    User::where('name', null)->delete();
    $user = User::first();
    if($user)
    {
      $user = User::where('card_id',  $data['card_id'])->first();
    }

    if ( !$user ) {
      User::create([
          'card_id' => $data['card_id'],
      ]);
      echo "added";
      event(new NewCard($data['card_id']));
    } else {
      echo "card is already used";
    }
  }

  public function addName(Request $request)
  {
      $user = User::orderby('id','desc')->first();
      if ( !$user->name)
      {
        $user->name = $request->name;
        $user->save();
      }
      return back()->withsucces('succes');
  }
}
