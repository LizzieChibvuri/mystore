<?php

namespace App\Http\Controllers;
use App\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session;

class ProductsController extends Controller
{

    /**
     * Create a new controller instance.
       except is to specify routes that are not authenticated
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fetch all products
        $products=Product::orderby('created_at','desc')->get();

        //pass products data to view
        return view('products.index',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //load create form
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate product data
        $this->validate($request,[ 
            'name'=>'required',
            'price'=>'required',
            'category'=>'required',
            'stocklevel'=>'required',
            'product_image'=>'image|nullable|max:1999'
            ]);

        //handle file uploads
        if($request->hasFile('product_image'))
        {
            //get file name with extension
            echo"inside hasfile";
            $filenamewithExt=$request->file('product_image')->getClientOriginalName();
            //get filename only
            $filename=pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //get extension only
            $extension=$request->file('product_image')->getClientOriginalExtension();
            $filenameToDB=$filename.'_'.time().'_'.$extension;
            $path=$request->file('product_image')->storeAs('public/product_photos',$filenameToDB);

        }
        else{

            $filenameToDB='noimage.jpg';
        }

        echo"b4 insert";
        //get product data
        $productData= new Product;
        //$productData=$request->all();
        $productData->name=$request->input('name');       
        $productData->price=$request->input('price');
        $productData->category=$request->input('category');       
        $productData->stocklevel=$request->input('stocklevel');
        $productData->product_image=$filenameToDB;
        //$productData->user_id=auth()->user()->id;

        //insert product dta
       //product::create($productData);
        echo"b4 save";
        $productData->save();

        //store status message
        Session::flash('success_msg','product added successfully');

        return redirect()->route('products.index');

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //fetch product data
        $product=Product::find($id);

        //pass data to details view
        return view('products.details',['product'=>$product]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get product data
        $product=Product::find($id);

        //load data in view
        return view('products.edit',['product'=>$product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          //validate product data
        $this->validate($request,[ 
            'name'=>'required',
            'price'=>'required',
            'category'=>'required',
            'stocknumber'=>'required',
            'product_image'=>'image|nullable|max:1999'
            ]);

             //handle file uploads
        if($request->hasFile('product_image'))
        {
            //get file name with extension
            $filenamewithExt=$request->file('product_image')->getClientOriginalName();
            //get filename only
            $filename=pathinfo($filenamewithExt,PATHINFO_FILENAME);
            //get extension only
            $extension=$request->file('product_image')->getClientOriginalExtension();
            $filenameToDB=$filename.'_'.time().'_'.$extension;
            $path=$request->file('product_image')->storeAs('public/product_photos',$filenameToDB);

        }
    

        
        //get product data
        $productData= Product::find($id);
        $productData->name=$request->input('name');       
        $productData->price=$request->input('price');
        $productData->category=$request->input('category');       
        $productData->stocknumber=$request->input('stocknumber');
        $productData->product_image=$filenameToDB;
        if($request->hasFile('product_image'))
        {
            $productData->product_image=$filenameToDB;
        }
      

        //update product dta
       $productData->save();

        //store status message
        Session::flash('success_msg','product updated  successfully');

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     
        //delete product dta
       $productData=Product::find($id);

       if($productData->photo_image!='noimage.jpg')
       {
            //delete image from store
            Storage::delete('public/product_photos/'.$productData->product_image);

       }

       $productData->delete();

        //store status message
        Session::flash('success_msg','product deleted successfully');

        return redirect()->route('products.index');
    }
}
