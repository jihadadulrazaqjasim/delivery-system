<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Location;
use Illuminate\Support\Facades\Auth;
 
class LocationController extends Controller
{
    public function __construct(Request $request)
    { 
        $this->middleware('auth');
        // $this->middleware(function ($request, $next) {
        //    if (Auth::user()->user_type!='admin'){
        //        return redirect()->back();
        //     //    die (Auth::user()->name);
        //    }
        //     return $next($request);
        // });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('locations.index');
    }

    public function getAllLocationNames()
    {
        if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'){
            return redirect()->back();
        }
        $locations=Location::select('id','location_name')->get();

        return response()->json($locations);
    }


    public function getAllLocations()
    {
        if (Auth::user()->user_type!='admin'){
            return redirect()->back(); 
        }

        $locations=Location::all();

        $new=array();
        foreach ($locations as $key => $location) {

            array_push($new,array(
                'id' => $location->id,
                'location_name' =>$location->location_name,
                "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$location->id.'" class="fa fa-edit btn btn-warning btn-sm rounded-1 update" data-toggle="tooltip" data-placement="top"></button></li>',
                "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$location->id.'" class="fa fa-trash btn btn-danger btn-sm rounded-1 delete" data-toggle="tooltip" data-placement="top"></button></li>'
            ));
        }

        return response()->json($new, 200);
    }

    // used while edit location, only admin can use this route
    public function getSingle($id)
    {
        if (Auth::user()->user_type!='admin'){
            return redirect()->back(); 
        }

        $location=Location::where('id',$id)->get();

        return response()->json($location, 200);
    }

    // while adding new location, only admin can see.
    public function store(Request $request)
    {
        if (Auth::user()->user_type!='admin'){
            return redirect()->back(); 
        }


        if($request->operation=='Add'){
            $location= new Location;

           $location->location_name = $request->location_name;
           $location->save();

        
        }else if($request->operation=='Edit'){
            $location=Location::find($request->location_id);

            $location->location_name=$request->location_name;

            $location->update();
        }
    
        }
           
    // while delete a location, only admin can use.
        public function locationDelete($id){
            if (Auth::user()->user_type!='admin'){
                return redirect()->back(); 
            }

        $location = Location::find($id);

        $location->delete();
        }
}