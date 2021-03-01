<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //

    public function create(){
        return view('users.signup');
    }

    public function show(User $user){
        return view('users.show',compact('user'));
    }

    public function store(Request $request){
        $this->validate($request,[
            'name' => "required|unique:users|max:255",
            "email" => "required|email|unique:users|max:255",
            "password" => "required|confirmed|min:4"
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        Auth::login($user);
        
        // return view('users.show',['user' => $user]);
        return redirect()->route('users.show', [$user]);
    }
}
