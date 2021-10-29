<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Admin;
use Validator;
use App\Http\Controllers\Controller;
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
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

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
        return Validator::make($data, [
            'username' => 'required|max:10|unique:users',
            'password' => 'required|min:6|confirmed',
            'user_type' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */ 
    protected function create(array $data)
    {
  
        $user= User::create([
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'user_type' => $data['user_type'],
        ]);


        $last_id=$user->id;

        // dd($last_id);

        if($data['user_type']=='Admin'){
         $admin=   Admin::create([
                'name' =>$data['name'],
                'phone_number'=>$data['phone_number'],
                'user_id'=>$last_id

            ]);
        }

        return $user;

    }
}
