<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Declarations;
use App\Models\vignettes;
use App\Models\User;
use App\Models\Engins;

use Redirect;

class QrCheckController extends Controller
{
    //
    public function CheckQr($unique_token)
    {
    	$declaration = Declarations::where('vignette_token',$unique_token)->first();
    	
    	if(!empty($declaration))
    	{
            $response       = array();
    		$proprietaire 	= User::find($declaration->userId);
    		$engin 			= Engins::find($declaration->enginId);
    		
            $response[]     = [
                                'proprietaire'  =>  $proprietaire,
                                'engin'         =>  $engin,
                                'declarer'      =>  true,
                                'exipired_at'   =>  $expires_at,
                            ];
            

            return $response;
    	}
    	else
    	{
    		$vignette 		= Vignettes::where('unique_token', $unique_token)->first();
            $expires_at     = $vignette->expired_at;
    		$proprietaire	= User::find($vignette->userId);
    		$engin 			= Engins::find($vignette->enginId);


            $response[]     = [
                                'proprietaire'  =>  $proprietaire,
                                'engin'         =>  $engin,
                                'declarer'      =>  false,
                                'exipired_at'   =>  $expires_at,
                            ];
            

            return $response;
    	}
    }


    // public function CheckChassie($chassie)
    // {
    //     $declaration = Declarations::where('vignette_token',$unique_token)->first();
        

    //     if(!empty($declaration))
    //     {
    //         $response       = array();
    //         $propriétaire   = User::find($declaration->userId);
    //         $engin          = Engins::find($declaration->enginId);
    //         $response[]     = $propriétaire;
    //         $response[]     = $engin;

    //         dd($response);
    //     }
    //     else
    //     {
    //         $vignette       = Vignettes::where('unique_token', $unique_token)->first();
    //         $propriétaire   = User::find($vignette->userId);
    //         $engin          = Engins::find($vignette->enginId);

    //         dd($engin);
    //     }
    // }
}
