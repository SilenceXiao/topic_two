<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    //

    public function __construct()
    {
        //中间键
        $this->middleware('auth',[
            'except' => ['show','create','store','index'], #指定不用过滤
            // 'only' => ['show','create','store'] # 指定过滤
        ]);

        $this->middleware('guest',[
            'only' => ['create']
        ]);
    }

    public function create(){
        return view('users.signup');
    }

    public function show(User $user){
        return view('users.show',compact('user'));
    }

    //用户注册
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


    public function edit(User $user){
        $this->authorize('update',$user);
        // return view('users.edit',compact('user'));
        return view('users.edit',['user' => $user]);
    }

    //编辑
    public function update(User $user, Request $request){
        $this->authorize('update',$user);
        
        $this->validate($request,[
            'name' => "required|unique:users|max:50",
            "password" => "nullable|confirmed|min:4"
        ]);
        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','更新成功');
        return redirect()->route('users.show',[$user]);
    }

    //列表
    public function index(){
        $users = User::paginate(5);
        return view('users.index',['users'=>$users]);
    }
}
