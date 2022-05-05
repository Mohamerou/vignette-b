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
        } 
        if($user->hasRole('elu')){
            return redirect()->route('get_elu_dash');
        }
        if($user->hasRole('guichet')){
            return redirect()->route('get_guichet_dash');
        }
        if($user->hasRole('superadmin')){
            return redirect()->route('get_superadmin_dash');
        }
        if($user->hasRole('comptable-public')){
            return redirect()->route('get_comptable_dash');
        }
        if($user->hasRole('caissier-en-chef')){
            return redirect()->route('get_comptable_dash');
        }
        if($user->hasRole('regisseur')){
            return redirect()->route('get_regisseur_dash');
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
        } 
        
    }
}
