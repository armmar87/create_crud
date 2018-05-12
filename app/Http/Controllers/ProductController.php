<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductsT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lang = app()->getLocale();
        $lang = Session::has('locale')?Session::get('locale'):$lang;

        $products = DB::table('products')
            ->join('products_t', 'products.id', '=', 'products_t.product_id')
            ->select('products.*', 'products_t.name as prod_name', 'products_t.description')
            ->where('products_t.code', $lang)
            ->get();

        return view('products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languges = DB::table('languages')->get();
        return view('products.create', compact('languges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        request()->validate([
            'name_hy' => 'required',
            'description_hy' => 'required',
            'price' => 'required|integer',
            'discount' => 'integer',
            'quantity' => 'integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $image_name);
        }

        $product = new Product;
        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;
        $product->image = $image_name;
        $product->save();

        $languges = DB::table('languages')->get();
        foreach ($languges as $languge) {
            $product_t = new ProductsT;
            $product_t->product_id = $product->id;
            $product_t->code = $languge->code;
            $product_t->name = !is_null($request['name_' . $languge->code])?$request['name_' . $languge->code]:'';
            $product_t->description = !is_null($request['description_' . $languge->code])?$request['description_' . $languge->code]:'';
            $product_t->save();
        }

        return redirect()->route('products.index')
            ->with('success','Product created successfully.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('products_t')->find($id);
//        dd($product->products_t);
        $languges = DB::table('languages')->get();
        return view('products.edit',compact('product', 'languges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        request()->validate([
            'name_hy' => 'required',
            'description_hy' => 'required',
            'price' => 'required|integer',
            'discount' => 'integer',
            'quantity' => 'integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $product = Product::with('products_t')->find($id);

        $image_name = $product->image;
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $image_name);
            $image_path = public_path('images/' . $product->image);
            if(file_exists($image_path)){
                @unlink($image_path);
            }
        }

        $product->price = $request->price;
        $product->discount = $request->discount;
        $product->quantity = $request->quantity;
        $product->image = $image_name;
        $product->save();

        $languges = DB::table('languages')->get();
        foreach ($languges as $key => $languge) {
            foreach ($product->products_t as $code => $products_t) {
                if ($key == $code) {
                    $products_t->code = $languge->code;
                    $products_t->name = !is_null($request['name_' . $languge->code])?$request['name_' . $languge->code]:'';
                    $products_t->description = !is_null($request['description_' . $languge->code])?$request['description_' . $languge->code]:'';
                    $products_t->save();
                }
            }
        }


        return redirect()->route('products.index')
            ->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }
}
