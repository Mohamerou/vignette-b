<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use App\Models\Engins;
use Illuminate\Http\Request;
use App\Models\Marque;
use App\Models\Administration;
use App\Models\Vignettes;
use Carbon\Carbon;

class EnginsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function selectEnginType()
    {

        return view('user.engins.selectType');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user           = Auth::user();
        $userId         = Auth::user()->id;
        $engins         = Engins::where('userId', $userId)->get();
        $vignettes      = Vignettes::where('userId', $userId)->get();



        
        if (!$engins->first()) {
            
            $empty = true;
            return view('user.engins.index')->with([
                'empty'     => $empty,
                'user'      => $user
                ]);
        }
        else {
           
            $empty = false;

            $awaiting_confirmation       = array();
            $up_to_date_vignettes        = array();
            $up_to_date_engins           = array();
            $out_dated_vignettes         = array();
            $out_dated_engins            = array();
            


            //////// ||- Vignettes encours ou expirées -|| \\\\\\\\\
            foreach ($vignettes as $vignette) 
            {
                $today                      = new Carbon();
                $vignette_expires_at        = $vignette->expired_at;
                

                //dd($vignette->expired_at);

                if($vignette->expired_at < $today){
                    $out_dated_vignettes[]   = $vignette;
                    $out_dated_engins[]      = Engins::where('id', $vignette->enginId)->first();
                }
                else{

                    $up_to_date_vignettes[]   = $vignette;
                    $up_to_date_engins[]      = Engins::where('id', $vignette->enginId)->first();
                }

            }
        }

        //dd($up_to_date_engins);

        //////// ||- Engins en attente de confirmation de vignette -|| \\\\\\\\\
        foreach ($engins as $engin) 
        {
            if (is_null($engin->vignetteId)) {
                
                $awaiting_confirmation[]   = $engin;
            }
        }

        //dd($awaiting_confirmation);
        //dd($vignette_less);
       
        //dd($confirmed_vignette_ids);

        return view('user.engins.index')->with([
            'empty'                         => $empty,
            'userId'                        => $userId,
            'awaiting_confirmations'        => $awaiting_confirmation,
            'up_to_date_vignettes'          => $up_to_date_vignettes,
            'out_dated_vignettes'           => $out_dated_vignettes,
            'up_to_date_engins'             => $up_to_date_engins,
            'out_dated_engins'              => $out_dated_engins,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type)
    {
        $marques = Marque::all();
        $mairies = Administration::all();
        switch ($type) {
            case 'moto51-125':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            case 'value':
                return view('user.engins.types.moto51-125')->with('marques', $marques)
                                                           ->with('mairies', $mairies);
                break;
            
            default:
                return view('user.engins.selectType')->with('unknown', 'Choix indisponible!');
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $userId = Auth::user()->id;
        
        request()->validate([
            'marque'                => 'required|string',
            'modele'                => 'required|string',
            'mairie'                => 'required|string',
            'chassie'               => 'required|string',
            'puissanceFiscale'      => 'required|string',
            'tarif'                 => 'required|integer',
            'documentJustificatif'  => 'required|file|image|max:4096',
        ]);

        $data           = request()->all();
        $IfEnginsExist  = Engins::where('chassie', $data['chassie'])->first();
        if($IfEnginsExist)
        {
            return back()->with('error', 'Un engin est enregistré sous le même numero de chassie')
                         ->withInput();
        }
        
        $engin =  Engins::create([
            'userId'                => $userId,
            'marque'                => $data['marque'],
            'modele'                => $data['modele'],
            'mairie'                => $data['mairie'],
            'chassie'               => $data['chassie'],
            'puissanceFiscale'      => $data['puissanceFiscale'],
            'tarif'                 => $data['tarif'],
            'documentJustificatif'  => $data['documentJustificatif'],
        ]);

            $token1 = md5(rand(1, 15) . microtime());
            $token2 = md5(rand(1, 15) . microtime());
            $token3 = md5(rand(1, 15) . microtime());
            $token4 = md5(rand(1, 15) . microtime());

            $enginId        = $engin->id;
            $enginId        = $token2.$token1.$enginId;
            $userId         = $token4.$token3.$userId;

            $this->storeFacture($engin);

            //dd("Okay");
            //return redirect()->route('user.demande_vignette', [['userdId' => $userId],['enginId' => $engin->id]]);

            return redirect('/vignettes/'.$enginId.'/'.$userId);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function show(Engins $engins)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function edit(Engins $engins)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Engins $engins)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Engins  $engins
     * @return \Illuminate\Http\Response
     */
    public function destroy(Engins $engins)
    {
        //
    }

    private function storeFacture($engin)
    {
        if (request()->has('documentJustificatif')) {
            $engin->update([
                'documentJustificatif' => request()->documentJustificatif->store('uploads/enginDocument', 's3'),
            ]);
        }
    }

}
