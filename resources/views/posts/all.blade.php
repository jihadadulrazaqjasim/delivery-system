
@extends('layouts.app')

@section('styles')
 
<link rel="stylesheet" href="{{URL::to('css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{URL::to('vendor/multiselect/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{URL::to('css/jquery.dataTables.css')}}">
{{-- <link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.dataTables.min.css')}}"> --}}
<link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.bootstrap.min.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{URL::to('css/posts.css')}}">
  
<style>

.col-form-label{
    color: rgb(7, 7, 7);
    /* background-color: rgb(255, 255, 245); */
    padding: 1px;
    border-radius: 2px;
    font-weight: 500;
}

tr{
    margin:0px;
    padding: 0px;
}

th{
margin:0px;
padding: 0px;
font-size: 13px;
}

td{
    font-size: 12px;
}

h1, h2, h3,h4{
    color: #1D67D6;
}

table{
    
}
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-2">

        {{-- Accept modal --}}
        <div id="deleteConfirmationModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content"> 
                    <div class="modal-header refused justify-content-center"> 
                        <div class="icon-box">
                            <i class="material-icons">help_outline</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Are you sure?</h4>	
                        <p>The post will be <span style="color: rgb(235, 28, 28);text-decoration:underline;">deleted</span> permenantly</p>
                        <div class="btn-group">
                        <button type="button" id="no" class="btn btn-warning" data-dismiss="modal">No</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-success"  id="yes" data-dismiss="modal" >Yes</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>

{{-- Edit  modal--}}    
    <!-- User Add Modal -->
    <div class="modal fade  " id="editModal" role="dialog" aria-labelledby="userAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="userAddModalLabel">Edit Post</h5> 
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="updateForm">
            <div class="modal-body">
             {{ csrf_field() }}
    
             <form>
                   {{-- Row --}}
                <div class="form-group row">
                    <div class="col-sm-6">
                         <label for="post_code" class="col-form-label" >Post code:</label>
                            <input type="text" class="form-control" id="post_code" name="post_code">
                            <div></div>
                        </div>

                    <div class="col-sm-6">
                        <label for="post_name" class="col-form-label">Post name:</label>
                        <input type="text" class="form-control" id="post_name" name="post_name">
                    </div>
{{-- 
                    <div class="col-sm-4">
                        <label for="post_created_date" class="col-form-label">Created Date:</label>
                        <input type="datetime-local" min="1997-01-01 08:45:25" max="2099-12-31 08:45:25" class="form-control" id="post_created_date" name="post_created_date">
                    </div> --}}
                </div>
                
                {{-- Row --}}
                
                <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="driver" class="col-form-label" >Driver:</label>
                        <select name="driver" id="driver" class="form-control" name="driver">
                      
                        </select>
                   </div>
        
                   <div class="col-sm-4">
                     <label for="store" class="col-form-label">Store:</label>
                        <select disabled readonly name="store" id="store" class="form-control" name="store">
                        </select>
                    </div>

                    <div class="col-sm-4">
                        <label for="location" class="col-form-label">Location</label>
                        <select name="location" id="location" class="form-control" name="location">
       
                        </select>
                    </div>
                 </div>

                  {{-- Row --}}
                
                  <div class="form-group row">
                    <div class="col-sm-4">
                        <label for="address" class="col-form-label" >Address:</label>
                        <input type="text" class="form-control" id="address" name="address">
                   </div>
        
                   <div class="col-sm-4">
                     <label for="post_phone_number" class="col-form-label">Phone Number:</label>
                     <input type="text" class="form-control" id="post_phone_number" name="post_phone_number">
                    </div>

                    <div class="col-sm-4">
                        <label for="comment" class="col-form-label">Comment</label>
                        <textarea name="comment" id="comment" class="form-control" cols="3" rows="3"></textarea>
                        </select>
                    </div>
                </div>

                {{-- Row --}}
                        
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="price" class="col-form-label" >Price:</label>
                        <input type="text" readonly class="form-control" id="price" name="price">
                    </div>

                    <div class="col-sm-6">
                        <label for="transportation_price" class="col-form-label">Transportation Price:</label>
                        <input type="text" class="form-control" id="transportation_price" name="transportation_price">
                    </div>
                    
                    {{-- <div class="col-sm-4">
                        <label for="status" class="col-form-label">Status</label> --}}
                        {{-- <input type="text" class="form-control" id="status" name="status"> --}}
                        {{-- <select name="status" readonly id="status">
                            <option value="new">New</option>
                            <option value="on the way">On the way</option>
                            <option value="refused">Refused</option>
                            <option value="delivered">Delivered</option>
                            <option value="delivered">Delivered</option> --}}
                        {{-- </select> --}}
                    {{-- </div> --}}
                </div>

              </form>
            </div> {{-- Modal body end --}}
            

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="save" id="save" class="btn btn-primary">Update</button>
    
              <input type="hidden" name="user_id" id="user_id">
              {{-- <input type="hidden" name="_token" id="_token"> --}}
            </div>
            <div id="errors"></div>
        </form>
          </div>
        </div>
      </div>


          <!-- DataTales Example -->
          <div class="card mb-3" style="margin:0px 10px;">

            {{--Card Header --}}
            <div class="card-header" style="background-color: rgb(255, 251, 218)">
                <div class="row">
                    <div class="col-md-12">  <div class="col-md-3" style="text-align: left;">
                        <h2>All posts</h2>
                    </div></div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3" style="text-align: left;">
                        <select id="locations" class="form-control" multiple="multiple"> 
                        </select>
                    </div>

                    <div class="col-md-3" style="text-align: left;">
                        <select id="stores" class="form-control" multiple="multiple">
                        </select>
                    </div>
                    <div class="col-md-3" style="text-align: left;">
                        <select id="drivers" class="form-control" multiple="multiple"> 
                        </select>
                    </div>
              <!-- End of row -->
            </div>
        </div>
        {{-- End of Card header --}}


            {{-- Card body which includes the datatable also --}}
        <div class="card-body" style="background-color: #f7f7d7"  id="post_table">
                <div class="table-responsive">
                    <table class="table table-bordered" id="allPostsTable" width="100%" cellspacing="0" paddingspacing="0">
                     
                    <thead>
                        {{ csrf_field() }}
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Driver</th>
                            <th>Store</th>
                            <th>City</th> 
                            <th>Address</th> 
                            <th>Phone</th>
                            <th>Price</th>
                            <th>Trans. Price</th>
                            <th>Date</th>
                            <th>Status</th>
                            {{-- <th>Comment</th> --}}
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>

                 </table>
    
                </div>     
            </div>
            <div class="card-footer" style="background-color: rgb(255, 251, 218)">

                <div style="text-align: right;margin-right:5%;">
                    <div class="col-md-12">
                    <div  class="card-title" style="font-weight: 550;color:#1D67D6">Price: <span class="h6 card-text" id="priceTotal"></span></div>
                    <div  class="card-title"style="font-weight: 550;color:#1D67D6">Trans.price: <span id="transPriceTotal" class="h6 card-text"></span></div>
                    </div>  
                </div>
        </div>
</div> 
    </div>
</div>
@endsection

@section('javascripts')
<script src="{{URL::to('vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{URL::to('vendor/multiselect/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{URL::to('vendor/popper/popper.js')}}" type="text/javascript"></script>

<script src="{{ URL::to('js/all.js') }}"></script>
<script src="{{URL::to('vendor/select-1.3.3/js/dataTables.select.min.js')}}"></script>
{{-- <script src="{{URL::to('vendor/jquery/slim.js')}}"></script> --}}

@endsection