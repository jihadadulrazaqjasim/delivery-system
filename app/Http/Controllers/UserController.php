<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Driver;
use App\Store;
use App\Admin;
use App\Employee;
use DB;
use Validator;

class UserController extends Controller 
{
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        // $users=User::all();
        return view('users.index'); 
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if($request->input('operation')=='Add'){
        $user=new User;
        $rules = array('username' => 'required|max:10|unique:users',
                       'password' =>'required|min:6|confirmed',
                        'user_type'=>'required');
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails())
        {
        return response()->json(array(
        'success' => false,
        'errors' => $validator->getMessageBag()->toArray()

        ), 400); // 400 being the HTTP code for an invalid request.
        }
 
        $user=new User;
        // To be added to the user table
        $user->username=$request->input('username');
        $user->password=bcrypt($request-> input('password'));
        $user->user_type=$request->input('user_type');

        $saved = $user->save();

        if($saved){
            $last_inserted_id = $user->id;
            
        if($request->input('user_type')=='admin'){
            $other_table=new Admin;
            $other_table->name=$request->input('name');
        }else if($request->input('user_type')=='employee'){
            $other_table=new Employee;
            $other_table->name=$request->input('name');
        }else if($request->input('user_type')=='driver'){
            $other_table=new Driver;
            $other_table->driver_name=$request->input('name'); 
        }else if($request->input('user_type')=='store'){
            $other_table=new Store;
            $other_table->store_name=$request->input('name');
            $other_table->owner_name=$request->input('owner_name');
            $other_table->address=$request->input('address');
        }
        
        $other_table->phone_number=$request->input('phone_number');
        $other_table->user_id=$last_inserted_id;

        $other_table->save();
        }

        //    If record successfully added into users table then to add the last added ID to the drivers or
        //    or store table depend on user_type

       return response()->json($other_table);
        } // End of Add operation


        // Edit Operation
    else if ($request->input('operation')=='Edit'){

            $user_id=$request->input('user_id');
            $user=  User::find($user_id);

            //store values before update
            $old=  User::find($user_id);

            $user->username=$request->input('username');
            $user->password=bcrypt($request-> input('password'));
            $user->user_type=$request->input('user_type');

            $updated = $user->update();

        if($updated){
            $last_updated_id=$user->id;
            //If record successfully updated on users table then to check if the user_type field changed?
            //if yes then to delete the record from previous table and add the new information to the new table
            $roles= ['stores'=>'store', 'drivers' => 'driver', 'employees'=>'employee', 'admins'=> 'admin'];

            if($user->user_type!=$old->user_type){
                $deleted='';
                
               foreach ($roles as $key => $value) {
                   
                  //Delete record from previous table
                   if($old->user_type==$value){
                    $deleted=DB::delete('delete from '. $key . ' where user_id = ?', [$old->id]);
                   }
             
               }if($deleted){
                
                   //Add record to the new table after deleted from the other table.
                   if($request->input('user_type')=='admin'){
                       
                    $addrecord=new Admin;

                    $addrecord->name=$request->input('name');
                   $addrecord->phone_number=$request->input('phone_number');
                   $addrecord->user_id=$last_updated_id;
                   $addrecord->save();
                    
                   }else if($request->input('user_type')=='employee'){
                    $addrecord=new Employee;
                    $addrecord->name=$request->input('name');
                    $addrecord->phone_number=$request->input('phone_number');
                    $addrecord->user_id=$last_updated_id;
                    $addrecord->save();
                    
                   }else if($request->input('user_type')=='store'){
                    $addrecord=new Store;
                    $addrecord->store_name=$request->input('name');
                    $addrecord->phone_number=$request->input('phone_number');
                    $addrecord->user_id=$last_updated_id;
                   
                    $addrecord->owner_name=$request->input('owner_name');
                    $addrecord->address=$request->input('address');
                    $addrecord->save();

                   }else if($request->input('user_type')=='driver'){
                    $addrecord=new Driver;
                    $addrecord->driver_name=$request->input('name');
                    $addrecord->phone_number=$request->input('phone_number');
                    $addrecord->user_id=$last_updated_id;
                    $addrecord->save();
                    
                   }
                  
                   return    \response()->json($addrecord);
                  
               
                  
                }
            }
            //means if the user_type didn't updated user_type then just to update the fields depend on user_type
            else{
                 
                if($request->input('user_type')=='admin'){
                    $other_table=Admin::where('user_id', $user_id)->first();

                    $other_table->name=$request->input('name');
                    $other_table->phone_number=$request->input('phone_number');
                    // $other_table->user_id=$user_id;
    
                    $other_table->save();
                }else if($request->input('user_type')=='employee'){
                   $other_table=Employee::where('user_id', $user_id)->first();
                    $other_table->name=$request->input('name');
                    $other_table->phone_number=$request->input('phone_number');
                    // $other_table->user_id=$user_id;
    
                    $other_table->update();
                }else if($request->input('user_type')=='driver'){
                    $other_table=Driver::where('user_id', $user_id)->first();                 
                       $other_table->driver_name=$request->input('name');
                    $other_table->phone_number=$request->input('phone_number');
                    // $other_table->user_id=$user_id;
    
                    $other_table->update();
                }else if($request->input('user_type')=='store'){
                    $other_table=Store::where('user_id', $user_id)->first();             
                           if($other_table){
                        $other_table->store_name=$request->input('name');
                        $other_table->phone_number=$request->input('phone_number');
                        // $other_table->user_id=$user_id;
        
                        
                    $other_table->owner_name=$request->input('owner_name');
                    $other_table->address=$request->input('address');
                    $other_table->update(); 
                    }
                 }
            }

        }//if the user table updated end

    }//End of Edit operation
       
    }//End of method

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getSingle(Request $request)
    { 
        $user=User::find($request->user_id);

        if($user->user_type=='store'){
            $new1=array();
     $users = DB::table('users')
     ->join('stores', 'users.id', '=', 'stores.user_id')
     ->select('users.id','users.username','users.user_type', 'stores.store_name','stores.phone_number',
     'stores.owner_name','stores.address')
     ->where('users.id',$request->user_id)
     ->get()->toArray();
     
       foreach ($users as $key => $user) {
         array_push($new1,array(
             'id' => $user->id,
             'name' => $user->store_name,
             'user_type' => $user->user_type,
             'username' => $user->username,
             'phone_number' => $user->phone_number,
             'owner_name' => $user->owner_name,
             'address' => $user->address,
             
         ));
     }

     return response()->json($new1);
 }

    else if($user->user_type=='driver'){
        $new1=array();
            $users = DB::table('users')
            ->join('drivers', 'users.id', '=', 'drivers.user_id')
            ->select('users.id','users.username','users.user_type', 'drivers.driver_name','drivers.phone_number')
            ->where('users.id',$request->user_id)
            ->get()->toArray();

            foreach ($users as $key => $user) {
                array_push($new1,array(
                    'id' => $user->id,
                    'name' => $user->driver_name,
                    'user_type' => $user->user_type,
                    'username' => $user->username,
                    'phone_number' => $user->phone_number,
                ));
            }

            return response()->json($new1);
        }
    else{
        $new1=array();
        if($user->user_type=='admin'){
            $users = DB::table('users')
            ->join('admins', 'users.id', '=', 'admins.user_id')
            ->select('users.id','users.username','users.user_type', 'admins.name','admins.phone_number')
            ->where('users.id',$request->user_id)
            ->get()->toArray();
        }else if($user->user_type=='employee'){
            $users = DB::table('users')
            ->join('employees', 'users.id', '=', 'employees.user_id')
            ->select('users.id','users.username','users.user_type', 'employees.name','employees.phone_number')
            ->where('users.id',$request->user_id)
            ->get()->toArray();
        }
        foreach ($users as $key => $user) {
          array_push($new1,array(
              'id' => $user->id,
              'name' => $user->name,
              'user_type' => $user->user_type,
              'username' => $user->username,
              'phone_number' => $user->phone_number,
          ));
      } 
      return response()->json($new1);
    }
      }
    
    /* Get all the users return json*/
    
    public function getAllUsers()
    {
        // $users=User::with('driver');
        // DB::select('select * from users join driver on where active = ?', [1])
        
        $usersWithDrivers = DB::table('users')
                ->join('drivers', 'users.id', '=', 'drivers.user_id')
                // ->join('drivers', 'users.id', '=', 'drivers.user_id')
                ->select('users.id','users.username','users.user_type', 'drivers.driver_name')
                ->get()->toArray();

                $usersWithStores =DB::table('users')
                ->join('stores', 'users.id', '=', 'stores.user_id')
                ->select('users.id','users.username','users.user_type', 'stores.store_name')
                ->get()->toArray();

                $usersWithAdmins =DB::table('users')
                ->join('admins', 'users.id', '=', 'admins.user_id')
                ->select('users.id','users.username','users.user_type', 'admins.name')
                ->get()->toArray();

                $usersWithEmployees =DB::table('users')
                ->join('employees', 'users.id', '=', 'employees.user_id')
                ->select('users.id','users.username','users.user_type', 'employees.name')
                ->get()->toArray();
 
                $new1= array();
                $new2= array();
                $new3= array();
                $new4= array();
 
                foreach ($usersWithDrivers as $key => $usersWithDriver) {
                    array_push($new1,array(
                        'id' => $usersWithDriver->id,
                        'name' => $usersWithDriver->driver_name,
                        'user_type' => $usersWithDriver->user_type,
                        'username' => $usersWithDriver->username,
                        
                        "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$usersWithDriver->id.'" class="fa fa-edit btn btn-warning btn-sm rounded-1 update" data-toggle="tooltip" data-placement="top"></button></li>',
                        "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$usersWithDriver->id.'" class="fa fa-trash btn btn-danger btn-sm rounded-1 delete" data-toggle="tooltip" data-placement="top"></button></li>'
        
                    ));
                }
               
                foreach ($usersWithStores as $key => $usersWithStore) {
                    array_push($new2,array(
                        'id' => $usersWithStore->id,
                        'name' => $usersWithStore->store_name,
                        'user_type' => $usersWithStore->user_type,
                        'username' => $usersWithStore->username,
                        "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$usersWithStore->id.'" class="fa fa-edit btn btn-warning btn-sm rounded-1 update" data-toggle="tooltip" data-placement="top"></button></li>',
                        "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$usersWithStore->id.'" class="fa fa-trash btn btn-danger btn-sm rounded-1 delete" data-toggle="tooltip" data-placement="top"></button></li>'
                    ));
                }

                foreach ($usersWithAdmins as $key => $usersWithAdmin) {
                    array_push($new3,array(
                        'id' => $usersWithAdmin->id,
                        'name' => $usersWithAdmin->name,
                        'user_type' => $usersWithAdmin->user_type,
                        'username' => $usersWithAdmin->username,
                        "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$usersWithAdmin->id.'" class="fa fa-edit btn btn-warning btn-sm rounded-1 update" data-toggle="tooltip" data-placement="top"></button></li>',
                        "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$usersWithAdmin->id.'" class="fa fa-trash btn btn-danger btn-sm rounded-1 delete" data-toggle="tooltip" data-placement="top"></button></li>'
                    ));
                }

                foreach ($usersWithEmployees as $key => $usersWithEmployee) {
                    array_push($new1,array(
                        'id' => $usersWithEmployee->id,
                        'name' => $usersWithEmployee->name,
                        'user_type' => $usersWithEmployee->user_type,
                        'username' => $usersWithEmployee->username,
                        "edit"=>'<li class="list-inline-item"><button type="button" name="update" id="'.$usersWithEmployee->id.'" class="fa fa-edit btn btn-warning btn-sm rounded-1 update" data-toggle="tooltip" data-placement="top"></button></li>',
                        "delete"=>'<li class="list-inline-item"><button type="button" name="delete" id="'.$usersWithEmployee->id.'" class="fa fa-trash btn btn-danger btn-sm rounded-1 delete" data-toggle="tooltip" data-placement="top"></button></li>'
                ));
                }
                $users=array_merge($new1, $new2,$new3,$new4);
                 
                 return response()->json($users);
            }
    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function deleteUser(Request $request)
    {
        $user_id=$request->input('user_id');

        $user = User::find($user_id);

        
        $user->delete();

    }
}
