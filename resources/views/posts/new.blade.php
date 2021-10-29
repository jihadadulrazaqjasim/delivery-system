
@extends('layouts.app')

@section('styles')

<link rel="stylesheet" href="{{URL::to('css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{URL::to('vendor/multiselect/css/bootstrap-multiselect.css')}}">
<link rel="stylesheet" href="{{URL::to('css/jquery.dataTables.css')}}">
{{-- <link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.dataTables.min.css')}}"> --}}

<link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.bootstrap.min.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{URL::to('css/posts.css')}}">
@endsection
 
@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-2">

        {{-- Success modal --}}
        <div id="successModal" class="modal fade">
            <div class="modal-dialog modal-confirm">
                <div class="modal-content">
                    <div class="modal-header justify-content-center">
                        <div class="icon-box">
                            <i class="material-icons">&#xE876;</i>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body text-center">
                        <h4>Great!</h4>	
                        <p>Posts successfully assigned to the driver, see driver <a href="" id="driverName"></a></p>
                        <button class="btn btn-success" data-dismiss="modal">
                            <span class="material-icons-outlined">
                            
                           <i class="material-icons">close</i>  </span> </button>
                    </div>
                </div>
            </div>
        </div>  
        
  <!-- Select Driver Modal -->
  <div class="modal fade" id="selectDriverModal" tabindex="-1" role="dialog" aria-labelledby="selectDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
             <h5 class="modal-title" id="selectDriverModalLabel">Select Driver</h5>&nbsp; <i  class="fas fa-car fa-2x"></i>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="selectDriverForm">
            <div class="modal-body">
            {{ csrf_field() }}
            
                <div class="form-group">
                <label for="drivers">Drivers:</label>
                <select class="form-control"  id="drivers" name="drivers">
                    {{-- <option value="admin">Admin</option>
                    <option value="employee">Employee</option>
                    <option value="driver">Driver</option>
                    <option value="store">Store</option>   --}}
                </select>
                <div class="alert alert-danger" style="display: none;">Select a role</div>
                <div></div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="save" id="save" class="btn btn-primary">Save</button>
            </div>
        </form>
       
        </div>
    </div>
  </div>



          <!-- DataTales Example -->
          <div class="card mb-3" style="margin: 0px 10px;"> 

            <div class="card-header" style="background-color: rgb(228, 220, 220);" >
                {{-- <i class="fa fa-table"></i> --}}
        <div class="row">
            <div class="col-sm-3" style="text-align: left;">
                <h2>New Posts</h2>
            </div>
            
        <div class="col-md-3" style="text-align: right;"> 
     {{-- <a href=""><i id="on-the-way" style="color: #617FD4" class="fas fa-arrow-alt-circle-right fa-2x"></i> --}}
        <div class="container">
            {{-- <h4   style="color: #9E8E96;" >Next</h4>     --}}
            {{-- data-toggle="modal" data-target="#selectDriverModal" --}}
              <a  style="text-decoration:none;" id="nextButton" href="" >
             <i id="next" style="color: #9E8E96" class="fas fa-arrow-alt-circle-right fa-2x"></i>
            </a>   
        </div> 
        </div>
        <div class="col-md-3"></div>
      
        </div>
        <!-- End of row -->
            </div>
            
        <div class="card-body" id="post_table"> 
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="postsTable" width="100%" cellspacing="0">
                     
                    <thead>
                        {{ csrf_field() }}
                        <tr>
                            <th style="width:3%">
                             <i id="checked-square" style="background-color: rgb(221, 209, 209)" class="fas fa-check-square"></i>
                             <i id="blank-square" class="fa fa-square" ></i>
                            </th>
                            <th style="width:3%">ID</th>
                            <th style="width:3%">Code</th>
                            <th style="width:15%">Post Name</th>
                            {{-- <th>Driver</th> --}}
                            <th style="width:10%">Store</th>
                            <th style="width:7%">City</th> 
                            <th style="width:12%">Address</th>
                            {{-- <th>Phone</th> --}}
                            <th style="width:7%">Price</th>
                            <th style="width:7%">Trans. Price</th>
                            <th style="width:15%">Entered Date</th>
                            <th style="width:7%">Status</th>
                        </tr>
                        </thead>
               
                {{-- <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>4544545554555</td>
                        <td>4544555</td>
                        </div>
                        </div>

                        </div>
                        </td>
                    </tr>
                </tfoot> --}}

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

<script src="{{ URL::to('js/new.js') }}"></script>
<script src="{{URL::to('vendor/select-1.3.3/js/dataTables.select.min.js')}}"></script>
@endsection