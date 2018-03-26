@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        @if(Session::has('success_msg'))
        <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
    <!-- products list -->
    @if(!empty($products))
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Products List </h2>
                </div>
                 @if (!Auth::guest())
                <div class="pull-right">
                    <a class="btn btn-success" href="{{ route('products.create') }}"> Add New</a>
                </div>
                @endif
            </div>
        </div>
        <div class="row">
           @foreach($products as $product)
            <div class="col-xs-12 col-sm-12 col-md-12">
             
                   <div class="col-md-4  col-sm-4">
                        <img style="width:100px; height:100px;" src="/storage/product_photos/{{$product->product_image}}">
                    </div>

                     <div class="col-md-8  col-sm-8">
                         <h3> <div><a href="{{ route('products.show', $product->id) }}">Product Name:{{$product->name}}</a></div></h3>
                         <p>Product Category:{{$product->category}}</p>
                         <p>Product Price:{{$product->price}}</p>
                         <p>Quantity in Stock:{{$product->stocklevel}}</p>
                         
                    </div>     
                    
            </div>
            <br/><br/>
             @endforeach
        </div>
        @else
        <strong>No products listed</strong>>
    @endif
    </div>
</div>
@endsection