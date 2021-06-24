<?php

namespace App\Http\Controllers;

use App\Models\Fiendship;
use App\Models\User;
use Illuminate\Http\Request;

class AcceptFriendshipsController extends Controller
{
    public function index(){
        $friendships =  Fiendship::with('sender')->where([
  
              'recipient_id' => auth()->id()
  
          ])->get();

          $sendFriendRequest = Fiendship::with('recipient')->where([
            'sender_id' => auth()->id(),
            "status" => 'pending'
          ])->get();

  
          return response()->json(["data" => $friendships, "sendRequests" => $sendFriendRequest], 200);
      }
  
      public function store(User $sender){
          Fiendship::where([
              'sender_id'=> $sender->id,
              'recipient_id' => auth()->id()
          ])->update(['status' => 'accepted']);
  
          $friendships =  Fiendship::with('sender')->where([
  
              'recipient_id' => auth()->id()
  
          ])->get();
      return response()->json([ 'data' => $friendships], 200);
  
      }
  
      public function destroy(User $sender) {
  
          Fiendship::where([
  
              'sender_id' => $sender->id,
              'recipient_id' => auth()->id(),
  
          ])->update(['status' => 'denied']);

          $friendships =  Fiendship::with('sender')->where([
  
            'recipient_id' => auth()->id()

        ])->get();
  
          return response()->json([
  
              'data' => $friendships
  
          ], 200);
  
      }
}
