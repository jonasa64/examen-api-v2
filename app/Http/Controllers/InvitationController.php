<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invitations = auth()->user()->invitations;

        $invitedTo = DB::table('invitation_people')->join('invitations', 'invitation_id', '=', 'invitations.id')->select('invitation_people.*', 'invitations.*')->where('invitation_people.user_id', '=', auth()->id())->get();
       return response()->json(['data' => $invitations, 'invitedTo' => $invitedTo], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(auth()->user()){
            $invitation = Invitation::create([
                'title' => $request["title"],
                'date' => $request["date"],
                'location' => $request["location"],
                'description' => $request["description"],
                'user_id' => auth()->user()->id
            ]);

            if($request->has('image')){
                $invitation->image = $request->input('image');
            } else {
                $invitation->image = 'https://firebasestorage.googleapis.com/v0/b/recipe-images-9a9cc.appspot.com/o/no-image.jpg?alt=media&token=c23fdbfa-0680-4125-bfe6-d41d5290ce62';
            }

            $invitation->save();

            return response()->json(["data" => auth()->user()->invitations], 201);
    }
    return response()->json(["data" => 'pleas log in'], 401);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invitation $invitation)
    {
        $invitationWithPersons = $invitation->fresh("invitationPerson");
        return response()->json(["data" => $invitationWithPersons] , 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Invitation $invitation )
    {
        if($invitation->isOwner()){
            $invitation->update([
          'title' => $request["title"],
          'date' => $request["date"],
          'location' => $request["location"],
          'image' => $request["image"],
          'description' => $request["description"],
          'user_id' => auth()->user()->id
      ]);

      return response()->json(["data" => auth()->user()->invitations->fresh('InvitedPerson')], 200);
  }

  return  response()->json(["data" => "you can not do this"], 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invitation $invitation)
    {
        if($invitation->isOwner()){
            $invitation->delete();
            return response()->json(['data' => null], 204);
        }



        return response()->json(["data" => "you can not do that"], 403);

    }
}
