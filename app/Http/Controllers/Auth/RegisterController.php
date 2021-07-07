<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserRegister;

class RegisterController extends Controller
{

    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('front.register');
    }

    public function store(Request $request)
    {
        // Проверим есть ли уже данные о таком user
        $account_old = DB::table('users')
            ->selectRaw('email')
            ->where('users.email', '=', $request->email)
            ->get();

        if(count($account_old)){
            foreach ($account_old as $el){
                return redirect()->route('register');
            }
        }
        $this->validate($request, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
        ]);

        $verified_token = generate();

        $user = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verified_token' => $verified_token,
        ]);

        auth()->attempt($request->only('email', 'password'));
        return redirect()->route('greet');
    }
}
