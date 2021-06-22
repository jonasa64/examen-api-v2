<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvitedPerson;
use Illuminate\Support\Facades\DB;
use App\Models\Invitation;

class InvitedPersonController extends Controller
{
    public function store(Request $request)
    {
        for ($i = 0; $i < count($request->data); $i++) {
            $invitedPersons[] = [
                "invitation_id" => $request->id,
                "user_id" => $request->data[$i]
            ];
        }
        InvitedPerson::insert($invitedPersons);
        return response()->json(['data' => "invitations created"], 201);
    }

    public function update(Request $request, Invitation $invitedPerson)
    {
        
       
        DB::update('UPDATE invitation_people SET status = ? WHERE user_id = ? and invitation_id = ?', [$request["status"], auth()->id(), $invitedPerson->id]);

        $invitedTo = DB::table('invitation_people')->join('invitations', 'invitation_id', '=', 'invitations.id')->select('invitation_people.*', 'invitations.*')->where('invitation_people.user_id', '=', auth()->id())->get();

        return response()->json(['invitedTo' => $invitedTo], 200);


    }
}
