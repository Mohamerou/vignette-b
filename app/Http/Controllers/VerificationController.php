<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TempVerificationCode;

class VerificationController extends Controller
{
    //
    public function registrationShow($phone)
    {
        //dd($phone);
        return view("user.verify")->with('phone', $phone);
    }

    //
    public function registration(Request $request)
    {
        $userPhone      =  $request->phone;
        $userInputCode  =  $request->code;

        $compareCode    =  TempVerificationCode::where('phone', $userPhone)->first();

        if(!empty($compareCode)){
            if($compareCode->code == $userInputCode)
            {
                $user               = User::where('phone', $userPhone)->first();
                $user->isverified   = true;
                $user->save();

                $compareCode->delete();
                $user->code         = "";
                $user->save();

                return redirect()->route('connexion')->with('success', "Votre compte est activé avec succès!");
            }
            else
            {
                return back()->withInputs()
                             ->with('error','Code incorrect!');
            }
        }
        return back()->with('error','Code incorrect!');
        

    }


   

    public function resendCode()
    {
    	
    }
}
