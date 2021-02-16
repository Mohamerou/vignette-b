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


   

    public function resend_code($phone)
    {
    	$code           = rand(100000, 999999);
        $user           = User::where('phone', $phone)->first();
        $userId         = $user->id;
        $user->code     = $code;
        $user->save();

        $oldTempVerificationCode       = TempVerificationCode:: where('userId', $userId)->first();

        $oldTempVerificationCode->delete();

        $newTempVerificationCode          = new TempVerificationCode;
        $newTempVerificationCode->userId  = $userId;
        $newTempVerificationCode->code    = $code;
        $newTempVerificationCode->phone   = $phone;
        $newTempVerificationCode->save();

        $sentCode       = Nexmo::message()->send([
                        'to'   => '+223'.$phone,
                        'from' => '+22389699245',
                        'text' => 'ikV, code de vérification: '.$code.' \n',
                    ]);


        return redirect()->route('verify',$phone);
    }
}
