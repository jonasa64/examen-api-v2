<?php

namespace App\Http\Controllers;
use App\Models\Fiendship;
use App\Models\User;
use Illuminate\Http\Request;

class FriendshipsController extends Controller
{
    public function store(User $recipient)
    {
        if(auth()->id() == $recipient->id){
            return response()->json(["data" => "can di that"], 400);
        }

        $friendship = Fiendship::firstOrCreate([
           'sender_id' => auth()->id(),
           'recipient_id' =>  $recipient->id
        ]);

        return response()->json(["data" => $friendship->fresh()->status], 201);
    }

    public function destroy(User $user)
    {
        $friendship = Fiendship::scopeBetweenUsers(auth()->user(), $user )->first();

        if ($friendship->status === 'denied' && (int) $friendship->sender_id === auth()->id()) {

            return response()->json([

                'friendship_status' => 'denied'

            ]);

        }

        return response()->json([

            'friendship_status' => $friendship->delete() ? 'deleted' : ''

        ]);

    }

    public function search(Request $request) {
       $users =  User::Where('name', 'like', "$request->name%")->get();
       return response()->json(["users" => $users]);
    }

}
