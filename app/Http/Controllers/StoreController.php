<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Store;
use Illuminate\Support\Facades\Auth;
class StoreController extends Controller
{ 
    public function __construct(Request $request)
    { 
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'&&Auth::user()->user_type!='store'){
                return redirect()->back();
            }
            
             return $next($request);
         });
    }
    
    public function index()
    {
        return view('stores.index');
    }
    
    public function getAllStores()
    {
        if (Auth::user()->user_type!='admin'){
            return redirect()->back();
        }

        $stores = DB::table('stores')
         ->select('id','store_name','phone_number','debt_to_store')
             //  ->join('users', 'users.id', '=', 'drivers.user_id')
         ->get();
    
    
        $new1=array();
        
        foreach ($stores as $key => $store) {
            array_push($new1,array(
                'id' => $store->id,
                'store_name' => $store->store_name,
                'phone_number' => $store->phone_number,
                'debt_to_store' => $store->debt_to_store,
                'more'=>'<a href="store/'. $store->id .'/posts" class="more" id"=' . $store->id .'">More</a>',
            ));
        }
        
         return   \response()->json($new1);
    }


    public function getAllStoreNames()
    {
        if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'){
            return redirect()->back();
        }

        $stores=Store::select('id','store_name')->get();
        
        return response()->json($stores);
    }
    
    //Get id of a store as parameter
    public function show($id)
    {
        $isOwner=false;

        // Here we are going to restrict
        $user_id=Auth::user()->id;
        
        if(Auth::user()->user_type=='store'){

        $users = DB::table('users')
        ->join('stores', 'users.id', '=', 'stores.user_id')
        ->selectRaw('users.id as user_id, stores.id as store_id')
        ->where('users.id',$user_id)
        ->get();

        foreach ($users as $key => $user) { 
            $store_id= $user->store_id;
         }
         
        if($store_id==$id)
        {
            $isOwner=true;
        }
      }

        if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'&&$isOwner!=true){
            return redirect()->back();
        }
        $store=Store::where('id','=', $id)->first(); 
 
        $posts = DB::table('stores')
     ->leftjoin('posts', 'stores.id', '=', 'posts.store_id')
     ->leftjoin('drivers', 'drivers.id', '=', 'posts.driver_id')
     ->leftjoin('locations', 'locations.id', '=', 'posts.location_id')
     ->select('posts.id','posts.post_name', 'posts.post_code' ,'drivers.driver_name', 'posts.address', 
     'stores.store_name', 'locations.location_name' ,'posts.address', 'posts.price', 'posts.check_out_time' ,
     'posts.transportation_price', 'posts.status','posts.created_at')
     ->where('stores.id', '=' , $id)->orderby('posts.id','desc')->get();
        // $driver_name = $posts->pluck('driver_name')->first();
     return view('stores.show',compact('posts'), ['store_name'=> $store->store_name]);
    
    }
}
