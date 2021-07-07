<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect('/');
    }
}
