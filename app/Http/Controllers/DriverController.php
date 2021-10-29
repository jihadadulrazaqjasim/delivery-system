<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use DB;
use App\Post;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function __construct(Request $request)
    { 
        $this->middleware('auth');
    }
    
    /**
     * Display all the drivers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
           if (Auth::user()->user_type!='admin'){
               return redirect()->back();
           }
        return view('drivers.index');
    }
    // All drivers
    public function getAllDrivers()
    {
            if (Auth::user()->user_type!='admin'){
                return redirect()->back();
            }

     $drivers = DB::table('drivers')
    //  ->join('users', 'users.id', '=', 'drivers.user_id') 
     ->select('id','driver_name','phone_number') 
     ->orderby('id','desc')
     ->get();

 
    $new1=array();
    
    foreach ($drivers as $key => $driver) {
        array_push($new1,array(
            'id' => $driver->id,
            'driver_name' => $driver->driver_name,
            'phone_number' => $driver->phone_number,
            // 'username' => $driver->username,
            'more'=>'<a href="driver/'. $driver->id .'/posts" class="more" id"=' . $driver->id .'">More</a>',
        ));
    }


     return   \response()->json($new1);
    }

    //Get all driver names (used by driverSelectModal in posts tab)
    public function getAllDriverNames()
    {

        if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'){
            return redirect()->back();
        }
        $drivers=Driver::select('id','driver_name')->get();
        
        return response()->json($drivers); 
    }

    /**
     * Display all the posts related to a specfic driver
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $isOwner=false;

        // Here we are going to restrict
        $user_id=Auth::user()->id;
        
        if(Auth::user()->user_type=='driver'){

        $users = DB::table('users')
        ->join('drivers', 'users.id', '=', 'drivers.user_id')
        ->selectRaw('users.id as user_id, drivers.id as driver_id')
        ->where('users.id',$user_id)
        ->get();

        foreach ($users as $key => $user) { 
            $driver_id= $user->driver_id;
         }
         
        if($driver_id==$id)
        {
            $isOwner=true;
        }
      }
    
        if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'&&$isOwner!=true){
            return redirect()->back();
        }
     $driver=Driver::where('id','=', $id)->first();
        
      $posts = DB::table('drivers')->where('drivers.id' , '=' , $id)
     ->leftjoin('posts', 'posts.driver_id', '=', 'drivers.id')
     ->leftjoin('stores', 'stores.id', '=', 'posts.store_id')
     ->leftjoin('locations', 'locations.id', '=', 'posts.location_id')
     ->select('posts.id','posts.post_name', 'posts.post_code' ,'drivers.driver_name', 'posts.address', 
     'stores.store_name', 'locations.location_name' ,'posts.address', 'posts.price', 
     'posts.check_out_time' ,'posts.transportation_price', 'posts.status','posts.created_at')
     ->orderby('posts.id','asc')->get();

    //  return $posts;
        // $driver_name = $posts->pluck('driver_name')->first();
     return view('drivers.show',compact('posts'), ['driver_name'=> $driver->driver_name]);
    
    }

}
