<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
// use Datatables;
use DB;
use Carbon\Carbon;
use App\Driver;
use App\Store;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Auth;
class PostController extends Controller
{
    public function __construct(Request $request)
    {

        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
           if (Auth::user()->user_type!='admin'&&Auth::user()->user_type!='employee'){
               return redirect()->back();
           }
           
            return $next($request);
        });
        
        date_default_timezone_set("Turkey");
    }
    
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   
    public function index()
    {
        return view('posts.index');
    }


    public function all() 
    {
        return view('posts.all'); 
    }

    public function new()
    {
        return view('posts.new');
    }

    // To return on the way posts view.
    public function onTheWay()
    {
        return view('posts.on-the-way');
    }


    public function delivered()
    {
        return view('posts.delivered');
    }

    public function refused()
    {
        return view('posts.refused');
    }
    
    public function add()
    {
        return view('posts.add');
    }

    public function getCounts()
    {
        $data=[];
        $new=Post::where('status','new')->count();
        $onTheWay=Post::where('status','on the way')->count();
        $delivered=Post::where('status','delivered')->count();
        $refused=Post::where('status','refused')->count(); 
        $data=["new"=>$new,"onTheWay"=>$onTheWay,"delivered"=>$delivered,"refused"=>$refused];
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // Admin and Employee can use
    public function store(Request $request)
    {
        $input = Input::all();
        $condition = $input['post_code'];

        // Do some validation (Don't forget)
        // Loop thru all then save them to database
        foreach ($condition as $key => $condition) {
            $post = new Post;
            $post->post_code = $input['post_code'][$key];
            $post->post_name = $input['post_name'][$key];
            $post->address = $input['address'][$key];
            $post->price = $input['price'][$key];
            $post->transportation_price = $input['transportation_price'][$key];
            $post->location_id = $input['location'][$key];
            $post->driver_id = $input['driver'][$key];
            $post->store_id = $input['store'];
            $post->comment=$input['comment'][$key];
            $post->post_phone_number=$input['post_phone_number'][$key];
            $post->check_out_time=Carbon::now();
            $post->save();
        }
        
        // Save the total prices as debt to store table

        $store_id = $input['store'];
        $totalPrice=$input['totalPrice'];
        $store=Store::find($store_id);
        
        $store->debt_to_store += $totalPrice=$input['totalPrice'];

        $store->update();
        

        // print_r($request->input('mydata'));
        return response()->json($request->input('post_code'), 200);
    }


    // Admin and Employee can use
    public function getSingle($id)
    {
        $post=Post::query()->with(array('driver' => function($query){
            $query->select('id','driver_name');
        }, 'store'=> function($query){
            $query->select('id','store_name');
        }, 'location'=> function($query){
            $query->select('id','location_name');
        }))->where('posts.id',$id)->orderby('posts.id','desc')->get()->toArray();

        if($post)
        return response()->json($post, 200);

        // $new=array();

        // foreach ($posts as $key => $post){
        // array_push($new,array(
        //     'id' => $post['id'],
        //     'post_name' => $post['post_name'],
        //     'post_code' => $post['post_code'],
        //     'driver_name' => $posts[$key]['driver']['driver_name'],
        //     'store_name' => $posts[$key]['store']['store_name'],
        //     'location_name' => $posts[$key]['location']['location_name'],
        //     'address'=>$post['address'],
        //     'price'=>$post['price'],
        //     'transportation_price'=>$post['transportation_price'],
        //     'status'=>$post['status'],
        //     'comment'=>$post['comment'],
        //     'post_phone_number'=>$post['post_phone_number'],
        //     'created_at'=>$post['created_at'],
        //     "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$post['id'].'" class="fa fa-edit btn btn-success btn-sm rounded-0 update" data-toggle="tooltip" data-placement="top"></button></li>',
        //     "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$post['id'].'" class="fa fa-trash btn btn-danger btn-sm rounded-0 delete" data-toggle="tooltip" data-placement="top"></button></li>'
        // ));
    // }
        // return response()->json($new, 200);
    }

    /**
     * Display all posts in a specific status
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // admin and employee can see
    public function getPosts(Request $request)
    {
        // return response()->json($request->status);
        $status=$request->status;
        // If the request contains drivers or stores
        //(multiselect dropdown in case of on the way, delivered and refused posts except new posts which dosn't contain drowdown)
        if($status=='all'){
            $posts=Post::query()->with(array('driver' => function($query){
            $query->select('id','driver_name');
        }, 'store'=> function($query){
            $query->select('id','store_name');
        }, 'location'=> function($query){
            $query->select('id','location_name');
        }));

        if($request->exists('drivers')){
            if($request->has('drivers')){
                $drivers=$request->drivers;
               $posts=$posts->wherein('posts.driver_id',$drivers);
            }
        }
        if($request->exists('stores')){
            if($request->has('stores')){
                $stores=$request->stores;
             $posts=$posts->wherein('posts.store_id',$stores);
            }
        }

        if($request->exists('locations')){
            if($request->has('locations')){
                $location=$request->locations;
               $posts=$posts->wherein('posts.location_id',$location);
            }
        }

        $posts=$posts->orderby('posts.id','desc')->get()->toArray();
        
        $new=array();

        foreach ($posts as $key => $post) {
            // return response()->json($post);
            array_push($new,array(
                'id' => $post['id'],
                'post_name' => $post['post_name'],
                'post_code' => $post['post_code'],
                'driver_name' => $posts[$key]['driver']['driver_name'],
                'store_name' => $posts[$key]['store']['store_name'],
                'location_name' => isset($posts[$key]['location']['location_name'])?$posts[$key]['location']['location_name']:'',
                'address'=>$post['address'],
                'price'=>$post['price'],
                'transportation_price'=>$post['transportation_price'],
                'status'=>$post['status'],
                'comment'=>$post['comment'],
                'post_phone_number'=>$post['post_phone_number'],
                'created_at'=>$post['created_at'],
                "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$post['id'].'" class="fa fa-edit btn btn-warning btn-sm rounded-1 update" data-toggle="tooltip" data-placement="top"></button></li>',
                "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$post['id'].'" class="fa fa-trash btn btn-danger btn-sm rounded-1 delete" data-toggle="tooltip" data-placement="top"></button></li>'
            ));
        }
        return response()->json($new);
    
        }else{
            // return response()->json($request->status);

            $posts=Post::query()->with(array('driver' => function($query){
                $query->select('id','driver_name');
            }, 'store'=> function($query){
                $query->select('id','store_name');
            }, 'location'=> function($query){
                $query->select('id','location_name');
            }))->where('posts.status',$status);
        

        if($request->exists('drivers')){
            if($request->has('drivers')){
                $drivers=$request->drivers;
               $posts=$posts->wherein('posts.driver_id',$drivers);
            }
        }
        if($request->exists('stores')){
            if($request->has('stores')){
                $stores=$request->stores;
             $posts=$posts->wherein('posts.store_id',$stores);
            }
        }
        
           $posts= $posts->orderby('posts.id','desc')->get()->toArray();
             return response()->json($posts);
    }

    }
    //Change status of a post
    // admin and employee can use
    public function changePostStatus(Request $request)
    {
        date_default_timezone_set("Turkey");

        $success=false;
        if($request->status=='new'){
            //and assign to a driver in case of "new" status
           $driver_id = $request->driver_id;
           $selectedPostIDs=$request->selectedPostIDs;

         

           foreach ($selectedPostIDs as $id) {
               $post=Post::find($id);
               $post->status='on the way';
               $post->driver_id=$driver_id;
               $post->check_out_time=Carbon::now();
               $value = $post->update();
               
               if($value){
                $success=true;
               }
           }
        }
        
        else{
            $selectedPostIDs=$request->selectedPostIDs;
            if($request->status=='on the way'){
            $newStatus=$request->newStatus;
            
           
        foreach ($selectedPostIDs as $id) {
            $post=Post::find($id);
            $post->status=$newStatus;
           $value= $post->update();
            if($value){
                $success=true;
               }
        }
        }
        else if($request->status=='delivered' ||$request->status=='refused'){
            $newStatus="done";
            $stores=Store::all();
        foreach ($stores as $store) {
            $amountToBePayBack=0;
            $value=0;
        foreach ($selectedPostIDs as $id) {
            $post=Post::find($id);
            $post->status=$newStatus;
            if(($post->store_id)==($store->id)){ 
                $amountToBePayBack=$amountToBePayBack+($post->price);
            }

        $value = $post->update();
            if($value){
            $success=true;
            }
        }
        // return response()->json($amountToBePayBack, 200);
        // End of posts loop
        
        //Check if the posts update were successfull
        if($value){
         //Clear the debt from the store table.
         $store->debt_to_store=($store->debt_to_store)-($amountToBePayBack);
        // $store->debt_to_store;
        //  return response()->json($store->debt_to_store, 200);
         $store->update();
        }
    }
    // End of stores loop
        }
        }
        
        if($success){
             return response()->json($post, 200);
        }
    }

    //never uses, will be used in second version, to reduce the number of requests
    public function getAllDriverAndStores() 
    {
        try{
        $drivers=DB::table('drivers')->select('id','driver_name')->get()->toArray();
        $stores=DB::table('stores')->select('id','store_name')->get()->toArray();
        $both=array();
        
        
        $both[]=[
            "drivers"=>$drivers,
            "stores" =>$stores
        ];
        return response()->json($both);
        }
        catch (\Exception $e) {
            return response()->json([],404);
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::find($id);
        $post->post_code=$request->input('post_code');
        $post->post_name=$request->input('post_name');
        $post->driver_id=$request->input('driver');
        $post->location_id=$request->input('location');
        // $post->store_id=$request->input('store');
        $post->address=$request->input('address');
        $post->post_phone_number=$request->input('post_phone_number');
        $post->price=$request->input('price');
        $post->transportation_price=$request->input('transportation_price');
        // $post->status=$request->input('status');
        $post->comment=$request->input('comment');

        // if($request->has('post_created_date')){
        // $date=$request->input('post_created_date');
        // $post->created_at = Carbon::createFromFormat('Y/m/d H:i:s', $date);
        // }
        $post->update();

        // return response()->json($request->store, 200);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post_id=$id;

        $post = Post::find($post_id);

        $store_id = $post->store_id;
        $post->delete();


    // If the post deleted, clear the debt for the store the post is belongs to
        if($post){
            $store=Store::find($store_id);
            
            $store->debt_to_store -= $post->price;

            $store->update();
        }

    }
}
