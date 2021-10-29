
{{-- @extends('layouts.app') --}}

@section('styles')

{{-- <link rel="stylesheet" href="{{URL::to('css/dataTables.bootstrap4.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/multiselect/css/bootstrap-multiselect.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('css/jquery.dataTables.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.dataTables.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.bootstrap.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/bootstrap/css/bootstrap.css')}}"> --}}

{{-- <link rel="stylesheet" href="{{URL::to('vendor/font-awesome-4.7.0/bootstrap3.3.7.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/font-awesome-4.7.0/metisMenu.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/font-awesome-4.7.0/morris.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/font-awesome-4.7.0/sb-admin-2.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/font-awesome-4.7.0/font-awesome.min.css')}}"> --}}
 

<link rel="stylesheet" href="{{URL::to('vendor/bootstrap/bootstrap-icons-1.5.0')}}">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> 
<link rel="stylesheet" href="{{URL::to('css/posts.css')}}">

<style>
/* body{
    margin-top:20px;
    background:#FAFAFA;
} */
.order-card {
    color: #fff;
}

.bg-c-blue {
    background: linear-gradient(45deg,#4099ff,#73b4ff);
}

.bg-c-green {
    background: linear-gradient(45deg,#2ed8b6,#59e0c5);
}

.bg-c-yellow {
    background: linear-gradient(45deg,#FFB64D,#ffcb80);
}

.bg-c-pink {
    background: linear-gradient(45deg,#FF5370,#ff869a);
} 


.card {
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    box-shadow: 0 1px 2.94px 0.06px rgba(4,26,55,0.16);
    border: none;
    margin-bottom: 30px;
    -webkit-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.card .card-block {
    padding: 25px;
}

.order-card i {
    font-size: 26px;
}

.f-left {
    float: left;
}

.f-right {
    float: right;
}


h2,h6{
    color: snow;
}
</style>
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
        

          <!-- DataTales Example -->
          <div class="card mb-3" style="margin:0px 10px;">

            <div class="card-header" style="background-color: #FEFADA">
                <a href="{{URL::to('post/all')}}" style="" class="btn btn-info">All posts</a>
                
            <a id="add_post" href="{{URL::to('post/add')}}" style="" class="btn btn-success">Add posts</a>
        <!-- End of row -->
        
            </div>

             {{-- Card body --}}
        <div class="card-body" style="margin:0px 10px;background-color: white">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-blue order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">New posts</h6>
                                <h2 class="text-right"> <img class="f-left" style="background-color: white;border-radius:100%;border:2px solid black" 
                                    src="{{URL::to('vendor/bootstrap/bootstrap-icons-1.5.0/cart-plus.svg')}}" alt="New posts" 
                                    width="32" height="32">
                                    <i class="bi bi-x-circle"></i>
                                    <span id="newPostsCount"></span></h2>
                                {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                             
                            <a style="text-align: right;color:snow" href="{{URL::to('/post/new')}}" class="m-b-0">View Details</a>
                                 
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-yellow order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">On way posts</h6>
                                <h2 class="text-right">
                                    {{-- <i class="fas fa-rocket f-left" style=""></i> --}}
                                    <img class="f-left" style="background-color: white;border-radius:50%;border:2px solid black" 
                                    src="{{URL::to('vendor/bootstrap/bootstrap-icons-1.5.0/cursor.svg')}}" alt="Bootstrap" 
                                    width="32" height="32">
                                    <span id="onWayPostsCount"></span></h2>
                                <a style="text-align: right;color:snow" href="{{URL::to('/post/on-the-way')}}" class="m-b-0">View Details</a>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-green order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">Delivered posts</h6>
                                <h2 class="text-right"><img class="f-left" style="background-color: white;border-radius: 50%;" 
                                    src="{{URL::to('vendor/bootstrap/bootstrap-icons-1.5.0/check-circle.svg')}}" alt="Bootstrap" 
                                    width="32" height="32">

                                    <span id="deliveredPostsCount"></span></h2>
                                {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                                <a style="text-align: right;color:snow" href="{{URL::to('/post/delivered')}}" class="m-b-0">View Details</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-xl-3">
                        <div class="card bg-c-pink order-card">
                            <div class="card-block">
                                <h6 class="m-b-20">Refused posts</h6>
                                <h2 class="text-right">
                                    <img class="f-left" style="background-color: white;border-radius: 50%;" 
                                    src="{{URL::to('vendor/bootstrap/bootstrap-icons-1.5.0/x-circle.svg')}}" alt="Bootstrap" 
                                    width="32" height="32">
                                    <span id="refusedPostsCount"></span></h2>
                                {{-- <p class="m-b-0">Completed Orders<span class="f-right">351</span></p> --}}
                                <a style="text-align: right;color:snow"href="{{URL::to('/post/refused')}}" class="m-b-0">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                
        </div>
            </div>
  
</div> 
@endsection

@section('javascripts')
{{-- <script src="{{URL::to('vendor/datatables/jquery.dataTables.js')}}"></script> --}}
{{-- <script src="{{URL::to('vendor/multiselect/js/bootstrap-multiselect.js')}}" type="text/javascript"></script> --}}
{{-- <script src="{{URL::to('vendor/popper/popper.js')}}" type="text/javascript"></script> --}}

<script src="{{ URL::to('js/posts.js') }}"></script>
{{-- <script src="{{URL::to('vendor/select-1.3.3/js/dataTables.select.min.js')}}"></script> --}}
@endsection