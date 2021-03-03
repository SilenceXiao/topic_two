<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SessionsController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    public function create(){

        return view('sessions.login');
    }

    //保存登录时的用户会话
    public function store(Request $request){
        $loginmsg = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if(Auth::attempt($loginmsg,$request->has('remember'))){
            if(Auth::user()->active){ //激活状态

                session()->flash('success', '欢迎回来');
                $fallback = route('users.show', [Auth::user()]);
                return redirect()->intended($fallback);
                // return redirect()->route('users.show',[Auth::user()]);
                // return view('users.show',['user'=>Auth::user()]);
            }else{
                Auth::logout();
                session()->flash('worning', '账户未激活,请去邮箱激活');
                return redirect('/');
            }

        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;
    }

    public function destroy(){
        Auth::logout();
        session()->flash('success', '您已成功退出！');
        return redirect('login');
    }

}
