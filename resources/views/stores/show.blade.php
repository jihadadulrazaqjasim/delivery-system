@extends('layouts.app')

@section('styles')
<link href="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

<style>


</style>
@endsection

@section('content')
<div class="row"> 
    <div class="col-md-12 col-md-offset-2">
        <div class="container-fluid" style="text-align: left"> 
            <h4 id="driverNameText" class="h4 mb-2" style="text-align: left;">
              <i id="icon" style="background: white;" class="fas fa-fw fa-store fa-2x"></i>
             
                {{$store_name}}
        </h4>

        <div class="table-responsive">
            <table class="table table-bordered" cellspacing="0"  width="100%" id="singleStoreTable">
                <thead class="">
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Post Name</th>
                    <th scope="col">Post Code</th>
                    <th scope="col">Driver</th> 
                    {{-- <th scope="col">Store</th> --}}
                    <th scope="col">City</th>
                    <th scope="col">Address</th>
                    <th scope="col">Date</th> 
                    <th scope="col">Price</th>
                    <th scope="col">Trans Price</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($posts as $post)
                  <tr>
                    <th scopre="row">{{$post->id}}</th>
                    <td>{{$post->post_name}}</td>
                    <td>{{$post->post_code}}</td>
                    <td>{{$post->driver_name}}</td>
                    {{-- <td>{{$post->store_name}}</td> --}}
                    <td>{{$post->location_name}}</td>
                    <td>{{$post->address}}</td>
                    <td>{{$post->created_at}}</td>
                    <td>{{$post->price}}</td>
                    <td>{{$post->transportation_price}}</td>
                    <td>{{$post->status}}</td>
                  </tr>
                  @endforeach
                </tbody>

              </table>

              <tfoot>
                <div  style="text-align: center;" class="col-md-12">
                  <div  class="card-title" style="font-weight: 550">Price: <span class="h6 card-text" id="priceTotal"></span></div>
                  <div  class="card-title"style="font-weight: 550">Trans.price: <span id="transPriceTotal" class="h6 card-text"></span></div>
                  </div>
              </tfoot>
            </div>
        </div>
    </div>
</div>
<hr>
@endsection 

@section('javascripts')
<script src="{{URL::to('vendor/datatables/jquery.dataTables.js')}}"></script>
<script src="{{URL::to('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::to('js/singleStore.js')}}"></script>

@endsection