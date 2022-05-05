<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $notifications  = Auth::user()->unreadNotifications;
        $user           = Auth::user();
        // dd($notifications);

        if($user->hasRole('user')){
            return view('home')->with('user', $user)
                               ->with('notifications', $notifications);
        } else {
            # code...
        return redirect()->route('get_admin_dash');
        }
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userHome()
    {
        $notifications  = Auth::user()->notifications();
        $user           = Auth::user();

        if($user->hasRole('user')){
            return redirect()->route('home')->with('notifications', $notifications);
        } else {
            # code...
        return redirect()->route('get_admin_dash');
        }
        
    }
}
