<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //

    public function create(){
        return view('users.singup');
    }

    public function singup(Request $request){

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

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->bcrypt($request->password);
        // $user = User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => bcrypt($request->password),
        // ]);
        $user->save();
        dd($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');

        // return view('users.show',['user' => $user]);
        // return view('users.show',['user' => $user]);
        return redirect()->route('users.show', [$user]);
    }
}
