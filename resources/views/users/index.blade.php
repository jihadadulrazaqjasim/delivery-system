@extends('layouts.app')

@section('styles')
{{-- Custom for this page --}}
<link href="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
@endsection


@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-2">
 
  <!-- User Add Modal -->
  <div class="modal fade" id="userAddModal" tabindex="-1" role="dialog" aria-labelledby="userAddModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userAddModalLabel">Modal title</h5> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addForm">
        <div class="modal-body">
         {{ csrf_field() }}

              
         <div class="form-group">
          <label for="user_type">Role</label>
          <select class="form-control user_type" id="user_type" name="user_type"> 
            <option value="store">Store</option>  
            <option value="admin">Admin</option>
            <option value="employee">Employee</option>
            <option value="driver">Driver</option>
          </select>
          <div class="alert alert-danger" style="display: none;">Select a role</div>
          <div></div>
        </div>

              
                <div class="form-group"> 
                    <label for="username">Username</label>
                    <input type="text" class="form-control required" name="username" id="username" aria-describedby="username" >
                    <div class="alert alert-danger" style="display: none;">Username is required</div>
                    <div></div>
                  </div>
                  
                <div class="form-group">
                  <label for="password">Password</label>
                  <input name="password" type="password" class="form-control required" id="password" >
                <div class="alert alert-danger" style="display: none;">Password is required</div>
                <div></div>
                </div>

                <div class="form-group">
                  <label for="password-confirm">Confirm Password</label>
                      <input id="password_confirm" type="password" class="form-control required" name="password_confirmation" >
                      <div class="alert alert-danger" style="display: none;">Confirmation password is required</div>
                      <div class="alert alert-danger" style="display: none;">Password and password confirmation fields doesn't match</div>
                      <div></div>
                    </div>


                    <div class="form-group">
                      <label for="name">Name</label>
                      <input name="name" type="text" class="form-control required" id="name" >
                      {{-- <div class="alert alert-danger" style="display: none;">Fullname is required</div> --}}
                      <div></div>
                    </div>



                  <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                        <input id="phone_number" type="text" class="form-control required" name="phone_number">
                        <div class="alert alert-danger" style="display: none;">Phone number is requried</div>
                        <div></div>
                  </div>

 
                   {{-- Custom for store --}}
                    <div class="form-group" id="owner_name_parent">
                      <label for="owner_name">Owner name</label>
                          <input id="owner_name" type="text" class="form-control" name="owner_name">
                    </div>

                    <div class="form-group" id="store_address_parent">
                      <label for="store_address">Store Address</label>
                          <input id="store_address" type="text" class="form-control" name="store_address">
                    </div>
                   
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="save" id="save" class="btn btn-primary">Save changes</button>

          <input type="hidden" name="user_id" id="user_id">
          <input type="hidden" name="operation" id="operation">
          {{-- <input type="hidden" name="_token" id="_token"> --}}
        </div>
        <div id="errors"></div>
    </form>
      </div>
    </div>
  </div>

 
         <!-- Begin Page Content -->
         <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-2" style="text-align: center">Users</h1>
            <div style="text-align: initial;margin-left: 23px">
            <!-- Button trigger modal -->
                {{-- <a href="" id="add_button" style="text-decoration: none;margin:0px;padding: 0px;" class="fa fa-user-plus fa-2x" aria-hidden="true" data-toggle="modal" data-target="#userAddModal"></a> --}}
            </div>

            <!-- DataTales Example --> 
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 style="text-align: center" class="m-0 font-weight-bold text-primary">List of all users</h6> --}}
                    <a href="" id="add_button" style="text-decoration: none;margin:0px;padding: 0px;" class="fa fa-user-plus fa-2x" aria-hidden="true" data-toggle="modal" data-target="#userAddModal"></a>

                  </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="userTable" width="100%" height="100%"  cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>FullName</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    {{-- <th>Phone Number</th> --}}
                                    <th>Edit</th> 
                                    <th>Delete</th> 
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <tr>
                                  <th>ID</th>
                                    <th>FullName</th>
                                    <th>Username</th>
                                    <th>Role</th> --}}
                                    {{-- <th>Phone Number</th> --}}
                                    {{-- <th>Edit</th>
                                    <th>Delete</th> 
                                 </tr>
                            </tfoot> --}}
                             {{-- <tbody>
                               @foreach ($users as $user)
                               <tr>
                                <th>{{$user->id}}</th>
                                  <td>{{$user->fullname}}</td>
                                  <td>{{$user->username}}</td>
                                  <td>{{$user->user_type}}</td>
                                  <td>{{$user->phone_number}}</td>
                                  <td>{{$user->edit}}</td>
                                  <td>{{$user->delete}}</td>
                              </tr>
                               @endforeach
                                
                            </tbody>  --}}
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->

    </div>
</div>

@endsection
@section('javascripts')
<script src="{{URL::to('vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::to('js/users.js') }}"></script>
@endsection