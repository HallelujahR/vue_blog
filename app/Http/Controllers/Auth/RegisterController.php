<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        if($data['account_type'] == 'email'){
            return Validator::make($data, [
                'name' => 'required|string|max:100|unique:users',
                'accountSign' => ['required','string','max:32',function($attribute,$value,$fail){
                    if(User::where('account',$value)->first()){
                        return $fail($attribute.'is wrong');
                    };
                }],
                'passwordSign' => 'required|string|min:6|confirmed',
            ]);
        }else{

                return Validator::make($data, [
                    'name' => 'required|string|max:100|unique:users',
                    'accountSign' => ['required','string','max:20','regex:/^1[34578]{1}\d{9}$/',function($attribute,$value,$fail){
                        if(User::where('account',$value)->first()){
                                return $fail($attribute.'is wrong');
                            };
                        }],
                    'passwordSign' => 'required|string|min:6|confirmed',
                    'code'=> ['min:4',function($attribute, $value, $fail) use($data) {
                                if ($value != \Cache::get($data['codekey'])['code']){
                                    return $fail($attribute.' is wrong.');
                                }
                            }],
                ]);

        }
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        return User::create([
            'name' => $data['name'],
            'account' => $data['account'],
            'account_type'=>$data['account_type'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
