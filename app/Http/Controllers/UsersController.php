<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //

    public function create(){
        return view('users.singup');
    }

    public function singup(Request $request){

    }
}
