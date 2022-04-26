<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Models\User;
use App\Models\Engins;
use App\Models\Vignettes;
use App\Models\Declarations;

class SignalerPerduController extends Controller
{
    //
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:guichet');      
    }
    

     // User thief of property declaration
     public function declaration_de_perte($chassie)
     {
        $engin                       = Engins::where('chassie', $chassie)->first();
     
        $user                       = User::find($engin->userId);
        $vignette                   = Vignettes::where('enginId', $engin->id)->first();
         
         $vignette_unique_token      = $vignette->unique_token;
         $chassie                    = $engin->chassie;
          
 
         $Declaration    = Declarations::create([
             'vignette_token'    => $vignette_unique_token,
             'vignetteId'        => $vignette->id,
             'enginId'           => $engin->id,
             'userId'            => $user->id,
             'chassie'           => $chassie,
         ]);
 
 
         if (!empty($Declaration)) {
 
             $updateEngin = DB::table('engins')
                               ->where('id', $engin->id)
                               ->update(['signaler_perdue' => 1]);
             return redirect()->route('guichet.user.show', $user)->with('success', 'Déclaration soumise avec succès!');
         }
 
         //return back()->with('declared', 'Déclaration soumise avec succès!');
         return redirect()->route('guichet.user.show', $user)->with('error', "Une erreur s\'est produite lors de la déclaration. \nVeillez réessayer!");
     }


     
     public function annuler_declaration($chassie)
    {
        $engin                       = Engins::where('chassie', $chassie)->first();
        $user                        = User::find($engin->userId);
        $vignette                    = Vignettes::where('enginId', $engin->id)->first();

        $vignette_unique_token  = $vignette->unique_token;
        $declaration            = Declarations::firstWhere('vignette_token', $vignette_unique_token);


        $engin->signaler_perdue = 0;
        $engin->save();
        
        if($engin)
        {
            // Withdraw declaration
            $declaration->delete();
            return redirect()->route('guichet.user.show', $user)->with('success', 'Déclaration annulée avec succès!');
        }

        return redirect()->route('guichet.user.show', $user)->with('annuler', "Déclaration annulée avec succès!");
    }



}
