<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PartyController extends Controller
{
    public function createParty(Request $request)
    {
        try {
            Log::info('Init create channel');
            $validator = Validator::make($request->all(), [   
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $newParty = new Party();
            $newParty->name = $request->name;
            $newParty->game_id = $request->game_id; 

            $newParty->save();

            return response()->json(["data"=>$newParty, "success"=>'Party created'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to create the channel->'.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500); 
        }
    }

    public function getAllParties()
    {
        try {
            Log::info('Init get all channels');
            $party = Party::all(); 

            if(empty($party)){
                return response()->json(
                    [
                        "success" => "There are not parties"
                    ], 202
                );
            };
            Log::info('Get all channels');

            return response()->json($party, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get all channels->'.$th->getMessage());

            return response()->json([ 'error'=> 'Error, try again!'], 500);        }
    }

    public function getPartyById($id)  //by game id
    {
        try {
            Log::info('Init get channel by id');
            $party = DB::table('parties')->where('game_id',$id)->get();
          
            if(empty($party)){
                return response()->json(
                    [
                        "error" => "The party does not exists"
                    ],400
                );
            };
            
            return response()->json($party, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get channel by id->'.$th->getMessage());
        
            return response()->json([ 'error'=> 'Error, try again!'], 500);        }
    }

    public function updateParty(Request $request, $id)
    {
        try {
            Log::info('Update channel by id');

            $validator = Validator::make($request->all(), [   
                'name' => 'string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $party = Party::where('id', $id)->first();

            if(empty($party)){
                return response()->json(["error"=> "The party not exists"], 404);
            };

            if(isset($request->name)){
                $party->name = $request->name;
            }

            $party->save();

            return response()->json(["data"=>$party, "success"=>'party updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update the channel->'.$th->getMessage());
            return response()->json([ 'error'=> 'Error, try again!'], 500);        }
    }

    public function deleteParty($id)
    {
        try {
            Log::info('delete Channel');
            $party = Party::where('id', $id)->first();

            if(empty($party)){
                return response()->json(["error"=> "The party does not exists"], 404);
            };
            $party->delete();

            return response()->json(["data"=> "Party deleted"], 200);
            
        } catch (\Throwable $th) {
            Log::error('Failed to deleted the channel->'.$th->getMessage());
            return response()->json([ 'error'=> 'Error, try again!'], 500);        }
    }
}
