<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public $hasMany = [
    //     'statuses' => [Status::class],
    // ];

    public function gravatar($size = '140')
    {
        
        $hash = md5(strtolower(trim($this->email)));
        // return "http://www.gravatar.com/avatar/$hash?s=$size";
        // return "https://cdn.learnku.com/uploads/sites/KDiyAbV0hj1ytHpRTOlVpucbLebonxeX.png";
        return "/images/header.gif?s=$size";
    }

    public static function boot(){  
        parent::boot();
        
        static::creating(function($user){
            
            $user->active_token = Str::random(10);
        });

    }

    //用户多个动态
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    public function feed(){

        // return $this->statuses()->orderBy('created_at','desc');

        $user_ids = $this->followings->pluck('id')->toArray();
        array_push($user_ids, $this->id);
        return Status::whereIn('user_id', $user_ids)
                              ->with('user')
                              ->orderBy('created_at', 'desc');
    }

    //粉丝
    public function followers(){
        return $this->belongsToMany(User::class,'followers','user_id','follower_id');
    }

    //关注人
    public function following(){
        return $this->belongsToMany(User::class,'followers','follower_id','user_id');
    }


    //加关注
    public function follow($user_id){   
        if(!is_array($user_id)){
            $user_id = compact('user_id');
        }
        $this->following()->sync($user_id,false);

    }

    //取关注
    public function unfollow($user_id){
        if(!is_array($user_id)){
            $user_id = compact('user_id');
        }
        $this->following()->detach($user_id);
    }

    //是否已关注
    public function isFollowing($user_id){
        return $this->following->contains($user_id);
    }

}
