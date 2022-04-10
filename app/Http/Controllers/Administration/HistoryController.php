<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Nexmo;
Use App\Models\User;
use App\Models\Role;
use App\Models\AgentRef;
use App\Models\TownHall;
use App\Models\EnrollHistory;
use App\Models\SalesHistory;

class HistoryController extends Controller
{
    //


    public function enrollHistory()
    {
        
        $enrollHistory      = EnrollHistory::where('townHallRef', Auth::user()->administration)
                                           ->get();
       

        return view('guichet.enrollHistory')->with('enrollHistories', $enrollHistory);

    }
}
