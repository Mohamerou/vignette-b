<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator,Redirect,Response;

use App\Models\Guichet;

class GuichetController extends Controller
{
    public function createShow()
    {
        return view('adminGuichet.guichet.create');
    }

    public function index()
    {
        $guichet_ventes     = Guichet::where('type', 'vente')->get();
        $guichet_enrolls    = Guichet::where('type', 'enroll')->get();

            // dd($guichet_ventes, $guichet_enrolls);
        return view('adminGuichet.guichet.index')->with('guichet_ventes', $guichet_ventes)
                                                 ->with('guichet_enrolls', $guichet_enrolls);
    }


    public function postCreate(Request $request)
    {
       
        // 
        request()->validate([
            'type' 	                => 'required|string',
            'number'                => 'required|digits:2',
        ]);
         
        //dd($key);
        $data                   = $request->all();
        $guichet_number         = (string)$data['number'];
        $guichet_ref            = $data['type'].$guichet_number;

        // dd($guichet_ref);
        $IfGuichetExist         = Guichet::where('ref', $guichet_ref)->first();
        if (!empty($IfGuichetExist)) 
        {
    
            return redirect()->route('guichet.create')
                             ->with('error', 'Ce guichet existe deja!')
                             ->withInput();
        }

        $guichet = Guichet::create([
            'type' 	    => $data['type'],
            'number'    => $data['number'],
            'ref'       => $guichet_ref,
            'townHallRef'    => Auth::user()->administration,
        ]);
        
        if(!empty($guichet)) {
            return redirect()->route('guichet.create')
                             ->with('success', 'Guichet ajoute avec succes!.')
                             ->withInput();
        }

        return redirect()->route('guichet.create')
                         ->with('error', 'Un Probleme eest survenu lors de l\'ajout du guichet!')
                         ->withInput();

        
    }

    public function create(array $data)
    {
        $guichet = Guichet::create([
            'type' 	    => $data['type'],
            'number'    => $data['number'],
        ]);
        $guichetNumber = (string)$guichet->number;
        $guichet->ref           =  $guichet->type.$guichetNumber;
        $guichet->townHallRef   =  Auth::user()->administration;

        $guichet->save();

        //dd($guichet->ref);
            
        return $guichet;
    }
}
