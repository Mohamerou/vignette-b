<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Declarations;
use App\Models\Vignettes;
use App\Models\User;
use App\Models\Engins;

use Redirect;

class QrCheckController extends Controller
{
    //
    public function CheckQr($unique_token)
    {
        $vignette    = Vignettes::where('unique_token', $unique_token)->first();


        if(!empty($vignette))
        {

        	$declaration = Declarations::where('vignette_token',$unique_token)->first();
        	
        	if(!empty($declaration))
        	{
                $response       = array();
        		$proprietaire 	= User::find($declaration->userId);
        		$engin 			= Engins::find($declaration->enginId);

                $response[]     = [
                                    'declarer_voler'    =>  true,
                                    'proprietaire'      =>  $proprietaire,
                                    'engin'             =>  $engin,
                                    'vignette'          =>  $vignette,
                                    'exipired_at'       =>  $vignette->expired_at,
                                ];
                

                return $response;
        	}
        	else
        	{
        		$proprietaire	= User::find($vignette->userId);
        		$engin 			= Engins::find($vignette->enginId);


                $response[]     = [
                                    'declarer_voler'    =>  false,
                                    'proprietaire'      =>  $proprietaire,
                                    'engin'             =>  $engin,
                                    'vignette'          =>  $vignette,
                                    'exipires_at'       =>  $vignette->expired_at,
                                ];
                

                return $response;
        	}
        }
        else 
        {
           $response[]     = [
                                    'no_matching_vignette'   =>  true,
                             ];
                

                return $response; 
        }
    }

    public function ChassieCheck(Request $request)
    {
        $chassie    = $request->chassie;
        $engin      = Engins::where('chassie', $chassie)->first();


        if (!empty($engin)) {

            $declaration = Declarations::where('chassie',$chassie)->first();
            if(!empty($declaration))
            {
                $response       = array();
                $proprietaire   = User::find($declaration->userId);
                $vignette       = Vignettes::where('unique_token', $declaration->vignette_token)->first();
                $engin          = Engins::find($declaration->enginId);

                $expired_at     = $vignette->expired_at;

                $response[]     = [
                                    'declarer_voler'    =>  true,
                                    'proprietaire'      =>  $proprietaire,
                                    'engin'             =>  $engin,
                                    'vignette'          =>  $vignette,
                                    'exipired_at'       =>  $expired_at,
                                ];
                

                return view('ChassieCheckShowInfo')->with('usager', $proprietaire)
                                                   ->with('engin', $engin)
                                                   ->with('vignette', $vignette);
            }
            else
            {
                $vignette       = Vignettes::where('enginId', $engin->id)->first();
                $proprietaire   = User::find($vignette->userId);

                $response[]     = [
                                    'declarer_voler'    =>  false,
                                    'proprietaire'      =>  $proprietaire,
                                    'engin'             =>  $engin,
                                    'vignette'          =>  $vignette,
                                    'exipires_at'       =>  $vignette->expired_at,
                                ];
                

                return $response;
            }
        }
            $response[]     = [
                                    'no_matching_vignette'   =>  true,
                             ];
        
                return $response;   
    }
}
