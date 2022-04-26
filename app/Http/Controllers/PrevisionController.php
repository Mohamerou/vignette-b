<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prevision;
use DB;

class PrevisionController extends Controller
{
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {        
        $this->middleware('can:comptable-public');      
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $previsionList      = Prevision::orderBy('updated_at', 'desc')->get();
        $lastPrevision      = DB::table('previsions')->orderby('updated_at', 'desc')->first();
        return view('guichet.prevision')
                ->with('previsions', $previsionList)
                ->with('lastPrevision', $lastPrevision);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = request()->validate([
            'montant' => 'required | numeric'
        ]);

        $newPrevision = Prevision::create([
            'montant' => $validatedData['montant']
        ]);

        return redirect()->route('prevision.index')
                         ->with('success', 'Prevision definie avec succes !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $previsionEdit         = Prevision::findOrfail($id);
        $previsionList      = null;
        $prevision          = null;
        $lastPrevision      = null;
        
        return view('guichet.prevision')
        ->with('previsionEdit', $previsionEdit)
        ->with('previsionList', $previsionList)
        ->with('prevision', $prevision)
        ->with('lastPrevision', $lastPrevision);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $validatedData = request()->validate([
            'montant' => 'required | numeric'
        ]);

        $previsionEdit          = Prevision::findOrfail($id);
        $previsionEdit->montant = $validatedData['montant'];
        $previsionEdit->save();

        return redirect()->route('prevision.index')
                         ->with('success', "Prevision mise a jour avec succes !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
