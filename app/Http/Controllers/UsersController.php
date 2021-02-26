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

}
