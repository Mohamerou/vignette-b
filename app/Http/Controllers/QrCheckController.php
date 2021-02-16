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
    	

    	if($declaration)
    	{
    		$propriétaire 	= User::find($declaration->userId);
    		$engin 			= Engins::find($declaration->enginId);

    		dd($propriétaire);
    	}
    	else
    	{
    		$vignette 		= Vignettes::where('unique_token', $unique_token)->first();
    		$propriétaire	= User::find($vignette->userId);
    		$engin 			= Engins::find($vignette->enginId);

    		dd($engin);
    	}
    }
}
