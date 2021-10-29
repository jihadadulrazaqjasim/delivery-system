
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
 


</style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-2">

        {{-- Accept modal --}}
        <div id="confirmationModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content"> 
                    <div class="modal-header justify-content-center"> 
                        <div class="icon-box">
                            <i class="material-icons">help_outline</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Are you sure?</h4>	
                        <p>Posts Will be moved to <span style="color: rgb(87, 230, 31);text-decoration:underline;">delivered</span> status</p>
                        <div class="btn-group">
                        <button type="button" id="no" class="btn btn-warning" data-dismiss="modal">No</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-success"  id="yes" data-dismiss="modal" >Yes</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reject  modal--}}
        <div id="rejectconfirmationModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center refused">
                        <div class="icon-box">
                            <i class="material-icons">help_outline</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Are you sure?</h4>	
                        <p>Posts Will be moved to <span style="color: rgb(230, 61, 31);text-decoration:underline;">refused</span> status</p>
                        <div class="btn-group">
                        <button type="button" id="noR" class="btn btn-warning" data-dismiss="modal">No</button>&nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-success"  id="yesR" data-dismiss="modal" >Yes</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>


          <!-- DataTales Example -->
          <div class="card mb-3" style="margin:0px 10px;">

            {{--Card Header --}}
            <div class="card-header" style="background-color: rgb(228, 220, 220);text-" >
                {{-- <i class="fa fa-table"></i> --}}
      
                <div class="row">

                    <div class="col-md-3"><h3>On the way posts</h3></div> 
                </div>
        <div class="row">
            <div class="col-md-3"><h3></h3></div>
        <div class="col-md-3" style="text-align: left;">
        {{-- <h4 for="stores">Stores:</h4> --}}
            <select id="stores" class="form-control" multiple="multiple">

            </select>
        </div>

        <div class="col-md-3" style="text-align: left;">
            {{-- <h4 for="drivers">Driver:</h4> --}}
                <select id="drivers" class="form-control" multiple="multiple">                    
                </select>
            </div>
            
 
            <div class="col-md-3" style="text-align: right">
            <label for="postAcceptedLink">Posts Accepted</label>
                <a href="" style="text-decoration: none" id="postAcceptedLink"> <img width="30px" height="30px" style="max-height: 70px;max-width:70px;" 
                    id="postAcceptedIcon" src="{{URL::to('img/Accept-icon.png')}}" alt="postAcceptedIcon">
                </a>
                    <br>
                    <br>

                <label for="postRejectedLink">Posts Rejected</label>
                <a href="" id="postRejectedLink"> 
                    <img width="30px" height="30px" style="max-height: 70px;max-width:70px;" id="postRejectedIcon" 
                    src="{{URL::to('img/rejected.png')}}" alt="postRejectedIcon">

                </a>

            </div>
         

        </div>
        <!-- End of row -->
            </div>
            {{-- End of Card header --}}
            
            {{-- Card body which includes the datatable also --}}
        <div class="card-body" id="post_table">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="onTheWayPostsTable" width="100%" cellspacing="0">
                     
                    <thead>
                        {{ csrf_field() }}
                        <tr>
                            <th>
                             <i id="checked-square" style="background-color: rgb(221, 209, 209)" class="fas fa-check-square"></i>
                             <i id="blank-square" class="fa fa-square" ></i>
                            </th>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Post Name</th>
                            <th>Driver</th>
                            <th>Store</th>
                            <th>City</th> 
                            <th>Address</th> 
                            {{-- <th>Phone</th> --}}
                            <th>Price</th>
                            <th>Trans. Price</th>
                            <th>Entered Date</th>
                            <th>Status</th>
                        </tr>
                        </thead>

                 </table>
    
                </div>     
            </div>
            <div style="text-align: right;margin-right:5%;">
                <div class="col-md-12">
                <div  class="card-title" style="font-weight: 550">Price: <span class="h6 card-text" id="priceTotal"></span></div>
                <div  class="card-title"style="font-weight: 550">Trans.price: <span id="transPriceTotal" class="h6 card-text"></span></div>
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

<script src="{{ URL::to('js/on-the-way.js') }}"></script>
<script src="{{URL::to('vendor/select-1.3.3/js/dataTables.select.min.js')}}"></script>
@endsection