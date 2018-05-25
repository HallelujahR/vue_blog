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
        'name', 'account', 'password','account_type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
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
}
