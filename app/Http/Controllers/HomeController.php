<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    { 
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
           if (Auth::user()->user_type!='admin'){
               return redirect()->back();
            //    die (Auth::user()->name);
           }
            return $next($request);
        });
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Depend on the user_role to show different views
        
        return view('home');
    }
}