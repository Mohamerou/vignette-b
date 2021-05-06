<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;

class PasswordResetController extends Controller
{

    public function resetter($query)
    {
    	$phone 		= substr($query, start);
    }
}
