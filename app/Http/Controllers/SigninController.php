<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Driver;
use App\Store;
use App\Admin;
use App\Employee;
use DB;
class SigninController extends Controller

{
    public function __construct()
    { 
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function signin(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        
        if(Auth::attempt([
            'username' => $request->input('username'),
            'password' => $request->input('password')
        ], $request->has('remember'))){
           
            $id=Auth::user()->id;
            
           if(Auth::user()->user_type=='admin'){
        
            return redirect('/post');
           
            }
            else if(Auth::user()->user_type=='driver'){

            $users = DB::table('users')
            ->join('drivers', 'users.id', '=', 'drivers.user_id')
            ->selectRaw('users.id as user_id, drivers.id as driver_id')
            ->where('users.id',$id)
            ->get();

            // return response()->json($users, 200);
            
            foreach ($users as $key => $user) {
               $driver_id= $user->driver_id;
            }
            
            $path='driver/'.$driver_id.'/posts';
            return redirect($path);

            }else if(Auth::user()->user_type=='store'){
                $users = DB::table('users')
                ->join('stores', 'users.id', '=', 'stores.user_id')
                ->selectRaw('users.id as user_id, stores.id as store_id')
                ->where('users.id',$id)
                ->get();
    
                // return response()->json($users, 200);
                
                foreach ($users as $key => $user) {
                   $store_id= $user->store_id;
                }
                
                $path='store/'.$store_id.'/posts'; 
                return redirect($path);

            }else if(Auth::user()->user_type=='employee'){
                return redirect('/post');
            }
        }
         
        return redirect()->back()->with('fail', 'Authentication failed!');
    }

    public function show()
    {
        return view('login.show');
    }
}