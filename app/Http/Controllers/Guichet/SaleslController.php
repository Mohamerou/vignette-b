<?php

namespace App\Http\Controllers\Guichet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleslController extends Controller
{
    //

    public function enrolledUsersList()
    {
        return view('guichet.enrolledUsersList');
    }



    public function UserInfo()
    {
        return view('guichet.userInfo');
    }


    public function CSV()
    {
        return view('guichet.csv');
    }



    public function salesHistory()
    {
        return view('guichet.salesHistory');
    }
}
