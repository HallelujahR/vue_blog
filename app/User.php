<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'account', 'password','account_type','question_count','article_count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var arrays
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function postLogin(Request $request)
    {
        $name = $request->input('account');
        $password = $request->input('password');
        if( empty($remember)) {  //remember表示是否记住密码
            $remember = 0;
        } else {
            $remember = $request->input('remember');
        }
        //如果要使用记住密码的话，需要在数据表里有remember_token字段
        if (Auth::attempt(['account' => $account, 'password' => $password], $remember)) {  
            return redirect()->intended('/');
        }
        return redirect('/')->withInput($request->except('password'))->with('msg', '用户名或密码错误');
    }

    public function article(){
        return $this->hasMany('App\Article');
    }

    public function topic(){
        return $this->hasMany('App\Topic');
    }

    public function question(){
        return $this->hasMany('App\Question');
    }

    public function User_detail(){
        return $this->hasOne('App\User_detail');
    }

    public function comments(){
        return $this->hasMany('App\Comments');
    }

    public function User_agree_comment(){
        return $this->hasMany('App\User_agree_comment');
    }
}
