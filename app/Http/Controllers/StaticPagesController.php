<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaticPagesController extends Controller
{
    //

    public function home(){
        $statuses_data = [];
        if(Auth::check()){
            $statuses_data = Auth::user()->feed()->paginate(5);
        }
    	return view('static/home',compact('statuses_data'));
    }

    public function help(){
    	return view('static/help');
    }

    public function about(){
    	return view('static/about');
    }
}
