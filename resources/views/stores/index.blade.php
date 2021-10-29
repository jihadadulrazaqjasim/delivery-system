@extends('layouts.app')

@section('styles')
{{-- Custom for this page --}}
<link href="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<style>
th{
    font-family: Arial, Helvetica, sans-serif;
    font-weight: bold;
}
td{
    color: rgba(7, 7, 7, 0.952);
    font-weight: 500;
}

a.more{

    background-color: rgb(130, 171, 226);
  box-shadow: 0 5px 0 rgb(136, 149, 177);
  color: white;
  padding: 0.3em 1em;
  position: relative;
  text-decoration: none;
  text-transform: uppercase;
  border-radius: 10%;
}


a.more:hover {
  background-color: #1d67d6;
  cursor: pointer;
}

a.more:active {
  box-shadow: none;
  top: 5px;
}

</style>
@endsection

@section('content')

<div class="row">
    <div class="col-md-12 col-md-offset-2">
 
     <!-- Begin Page Content -->
         <div class="container-fluid">
          <div class="row">
            <div class="col-md-12 col-md-offset-2">
        <h1 class="h3 mb-2" style="text-align: center;">Stores</h1>
        {{-- <i style="background: white;text-align: center" class="fas fa-car fa-3x"></i> --}}

            </div>
          </div>
        <div class="table-responsive">
        <table class="table table-bordered" cellspacing="0"  width="100%" id="storesTable">
            <thead class="">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Debt</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            
          </table>
        </div>

         </div>
    </div>
</div>
@endsection

@section('javascripts')
<script src="{{URL::to('vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::to('js/stores.js')}}"></script>

@endsection