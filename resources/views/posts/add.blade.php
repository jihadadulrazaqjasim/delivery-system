
@extends('layouts.app')

@section('styles')

{{-- <link rel="stylesheet" href="{{URL::to('css/dataTables.bootstrap4.css')}}"> --}}
<link rel="stylesheet" href="{{URL::to('vendor/multiselect/css/bootstrap-multiselect.css')}}">
{{-- <link rel="stylesheet" href="{{URL::to('css/jquery.dataTables.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.dataTables.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{URL::to('vendor/select-1.3.3/css/select.bootstrap.min.css')}}"> --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="{{URL::to('css/posts.css')}}">
 
<style>

    #add_new_row_icon:hover, #delete_last_row_icon:hover{
        background-color: rgb(243, 179, 179); 
        box-shadow: 0 2px 0 rgb(228, 231, 33);
        /* color: rgb(188, 243, 181); */
        position: relative;
        text-decoration: none;
        text-transform: uppercase;
        border-radius: 50%;  
    }

    tr{
        margin:0px;
        padding: 0px;
    }
    th{
        margin:0px;
        padding: 0px;
    font-size: 12px;
    }

    td{
        font-size: 11px;
    }
</style>

@endsection

@section('content')
<div class="row">
    <div class="col-md-12 col-md-offset-2">

        <div class="card sb-3" style="margin:0px 10px;">

            <div class="card-header">
                <div class="row">
                    <div class="col-md-12" style="text-align: left;">
                        <h2 style="">Add Post</h2>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-3"></div> 
                        <div class="col-md-3"></div> 
                        <div class="col-md-3"></div> 
                        <div class="col-md-3">
                            <select id="stores" class="form-control">

                            </select>
                        </div>

                        {{-- <div  class="col-md-3">
                            <select id="drivers" class="form-control">

                            </select>
                        </div> --}}

                        {{-- <div hidden class="col-md-3">
                            <select id="locations" class="form-control">

                            </select>
                        </div> --}}

            </div>
            </div>

        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="table-responsive" >
                <form method="post" name="" id="myform">
                   {{ csrf_field() }}
                    <table width="100%" class="table table-bordered table-hover" id="tab_logic" cellspacing="0">
                    <thead>
                    <tr> 
                        <th class="text-center" style="width:5%;"> # </th>
                        <th class="text-center" style="width:10%;min-width: 130px;"> Code </th>
                        <th class="text-center" style="width:15%;min-width: 180px;"> Post Name </th>
                       
                        <th class="text-center" style="width:10%;min-width: 160px;"> Driver </th>
                        <th class="text-center" style="width:10%;min-width: 130px;"> City </th>

                        <th class="text-center" style="width:15%;min-width: 170px;"> Address </th>
                        <th class="text-center" style="width:15%;min-width: 160px;"> Phone</th>
                        <th class="text-center" style="width:10%;min-width: 110px;"> Price </th>

                        <th class="text-center" style="width:10%;min-width: 100px;"> Trans price </th>
                        

                        <th class="text-center" style="width:15%;min-width: 140px;"> Comment</th>

                        <!-- <th class="text-center"> Inc.QtY </th> -->
                    </tr>
                    </thead>
 
                    <tbody>
                        {{-- " --}} 
                    <tr id='addr0' style="display:none;">
                        <td style="width:5%">1</td>
                        <td style="width:10%"><input type="text" required name='post_code[]'  class="form-control post_code"></td>
                        <td style="width:15%"><input required type="text" min="1" name='post_name[]'  class="form-control post_name" ></td>
                        <td style="width:15%">
                            <select class="form-control driver" name="driver[]" required>
                            </select>
                        </td>
                        <td style="width:15%">
                            <select required class="form-control location" name="location[]" required>
                            </select>
                        </td>
                        <td style="width:15%"><input type="text" required name='address[]'  class="form-control address"></td>
                        <td style="width:10%"><input type="text" name='post_phone_number[]'  class="form-control post_phone_number"></td>
                        <td style="width:10%"><input type="number" required name='price[]'  class="form-control price" step="0.00" min="0"></td>
                        <td style="width:10%"><input type="number" name='transportation_price[]' required  class="form-control transportation_price" step="0.00" min="0"></td>
                        <td style="width:15%"><textarea name='comment[]'  class="form-control comment"></textarea></td>

                        <td hidden><input type="hidden" name='id[]' class="id"></td>
                    </tr>
                    <tr id='addr1'></tr>
                    </tbody>
                    
                </table>

            </div>

         </div>
     </div>
     
     <div class="row clearfix">
        <div class="col-sm-6" style="margin-top:5px;">
        <a href="" id="add_new_row" style="text-decoration: none;">
        <i id="add_new_row_icon" class="fas fa-plus-circle fa-2x" style="background-color: yellow;border-radius: 50%;text-shadow: 20%;color:rgb(102, 102, 240)"></i>
        </a>
        &nbsp;&nbsp;
        <a href="" id="delete_last_row" style="text-decoration: none;">
        <i id="delete_last_row_icon" class="fas fa-minus-circle fa-2x" style="background-color: yellow;border-radius: 50%;text-shadow: 20%;color:rgb(238, 124, 90)"></i>
    </a>
    </div>

        <div class=" col-sm-6" id="include">
            <table class="table table-bordered table-hover" id="tab_logic_total">
                <tbody>
                <tr>
                    <th class="text-center">Total Price</th>
                    <td class="text-center" ><input type="number" name='totalPrice' placeholder='0.00' class="form-control" id="totalPrice" readonly/></td>
                </tr>
                <tr>
                    <th class="text-center">Total Trans Price</th>
                    <td class="text-center" ><input type="number" name='totalTransPrice' placeholder='0.00' class="form-control" id="totalTransPrice" readonly/></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

            <div class="row clearfix">
            <div class="col-sm-3">
            <input name="cancel" type="button" id="cancel" value="Cancel" class="btn form-control btn-danger">
            </div>

            <div class="col-sm-3">
            <input name="save_post" type="submit" value="Save" class="btn form-control btn-success" id="save_post">
            </div>

            </div>
            
            </form>
        </div>
        </div>    
    </div>
</div>
@endsection

@section('javascripts')
{{-- <script src="{{URL::to('vendor/datatables/jquery.dataTables.js')}}"></script> --}}
<script src="{{URL::to('vendor/multiselect/js/bootstrap-multiselect.js')}}" type="text/javascript"></script>
<script src="{{URL::to('vendor/popper/popper.js')}}" type="text/javascript"></script>

<script src="{{ URL::to('js/add.js') }}"></script>
{{-- <script src="{{URL::to('vendor/select-1.3.3/js/dataTables.select.min.js')}}"></script> --}}
@endsection