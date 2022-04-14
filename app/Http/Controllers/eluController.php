<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class eluController extends Controller
{
    public function eluIndex()
    {

        return view('elu.eluDash');

    }
}
