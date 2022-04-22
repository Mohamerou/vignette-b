<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Engins;
use App\Models\EnrollHistory; 

class SalesController extends Controller
{
    //

    public function pendingSales()
    {
        $pendingSales = EnrollHistory::where('status', '1')->orderBy('created_at', 'desc')->get();

        // dd($pendingSales);

        $user_list       = [];
        $engin_list      = [];
        foreach($pendingSales as $pendingSale){
            $user   = User::find($pendingSale->userId);
            $engin  = Engins::find($pendingSale->enginId);

            $user_list[]  = [
                'userId'    => $user->id,
                'usager'    => $user->firstname." ".$user->lastname,
                'userphone' => $user->phone,
                'chassie'   => $engin->chassie, 
                'guichet'   => $pendingSale->guichetRef, 
                'enrollId'  => $pendingSale->id,
            ]; 
        }


        $pendingSales = $user_list;
 
        return view('guichet/salesIndex')
                ->with('pendingSales', $pendingSales);
    }



    public function stepOne(Request $request) 
    {
        $data = $request->validate([
            'enrollId'    => 'required|numeric',
        ]);

        dd($data);
    }

    public function UserInfo()
    {
        return view('guichet.userInfo');
    }


    public function CSV()
    {
        return view('guichet.csv');
    }



    public function salesHistory()
    {
        return view('guichet.salesHistory');
    }
}
