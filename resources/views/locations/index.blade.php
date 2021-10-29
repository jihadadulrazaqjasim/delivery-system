@extends('layouts.app')

@section('styles')
{{-- Custom for this page --}}
<link href="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<style>


    
</style>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-2">
 
  <!-- User Add Modal -->
  <div class="modal fade" id="locationAddModal" tabindex="-1" role="dialog" aria-labelledby="dataTableLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="dataTableLabel">Add User</h5> 
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="addForm">
        <div class="modal-body">
         {{ csrf_field() }}

            <div class="form-group">
                <label for="location_name">Name</label>
                <input type="text" class="form-control required" name="location_name" id="location_name" aria-describedby="location_name" >
                <div class="alert alert-danger" style="display: none;">The field can't be empty</div>
                <div></div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="save" id="save" class="btn btn-primary">Save changes</button>

          <input type="hidden" name="location_id" id="location_id"> 
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
            <h1 class="h3 mb-2 text-blue-800" style="text-align: center">Cities</h1>
            {{-- <div style="text-align: initial;margin-left: 23px"> --}}
            <!-- Button trigger modal -->
                {{-- <a href="" id="add_button" style="text-decoration: none;margin:0px;padding: 0px;" class="fa fa-user-plus fa-2x" aria-hidden="true" data-toggle="modal" data-target="#userAddModal"></a> --}}
           
            {{-- </div> --}}

            <!-- DataTales Example --> 
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    {{-- <h6 style="text-align: center" class="m-0 font-weight-bold text-primary">List of all cities</h6> --}}
                    <a href="" id="add_button"  aria-hidden="true" data-toggle="modal" data-target="#locationAddModal"> <span class="material-icons md-18" style="font-size: 35px; ">
                      add_location_alt
                      </span>
                  </a> 
                  </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="locationTable" width="100%" height="100%"  cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Edit</th> 
                                    <th>Delete</th> 
                                </tr>
                            </thead>
                            {{-- <tfoot>
                                <tr>
                                  <th>ID</th>
                                    <th>Name</th>
                                    <th>Edit</th>
                                    <th>Delete</th> 
                                 </tr>
                            </tfoot> --}}
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
<script src="{{ URL::to('js/locations.js') }}"></script>
@endsection