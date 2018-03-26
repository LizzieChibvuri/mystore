@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($products as $product)
                    <h3> <p><div><a href="{{ route('products.show', $product->id) }}">{{$product->name}}</a></div></p></h3>
                    <img style="width:200px;height:200px;" src="/storage/product_photos/{{$product->product_image}}"><br/>
                    <p>Product Category:{{$product->category}}</p>>
                    <p>Product Price:{{$product->price}}</p>>
                    <p>Quantity in Stock:{{$product->stocklevel}}</p>>
                    <a href="{{ route('products.edit', $product->id) }}" class="label label-warning">Edit</a>
                    <form action="{{action('ProductsController@destroy', $product->id)}}" method="product">
                    {{csrf_field()}}
                    <input name="_method" type="hidden" value="Delete">
                    <button class="btn btn-danger" type="submit"  onclick="return confirm('Are you sure to delete?')">Delete</button>
                    </form>
                    <br/><br/>
                     @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
