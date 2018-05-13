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
        $lang = Session::has('locale')?Session::get('locale'):app()->getLocale();

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
        foreach ($languges as $languge) {
            foreach ($product->products_t as $products_t) {
                if ($languge->code == $products_t->code) {
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

    public function searchProducts(Request $request)
    {
        request()->validate([
            'search' => 'required',
        ]);
        $lang = Session::has('locale')?Session::get('locale'):app()->getLocale();
        if($request->has('search')) {
            $search = $request->input('search');
            $search_data = explode(' ' , $search);
            $products = DB::table('products')
                ->leftjoin('products_t', 'products.id', '=', 'products_t.product_id')
                ->select('products.*', 'products_t.name as prod_name', 'products_t.description')
                ->where('products_t.code', $lang)
                ->where(function ($q) use ($search_data) {
                    foreach($search_data as $data){
                        $q->where('products_t.name', 'LIKE', '%' . strtolower($data) . '%');
                        $q->orWhere('products_t.description', 'LIKE', '%' . strtolower($data) . '%');
                    }})
                ->get();

            return view('products.index',compact('products'));
        }
    }

    public function searchProductsToPrice(Request $request)
    {
        request()->validate([
            'from' => 'required|integer',
            'to' => 'required|integer',
        ]);
        $lang = Session::has('locale')?Session::get('locale'):app()->getLocale();
        if($request->has('from') && $request->has('to')) {
            $from = $request->input('from');
            $to = $request->input('to');

            $products = DB::table('products')
                ->leftjoin('products_t', 'products.id', '=', 'products_t.product_id')
                ->select('products.*', 'products_t.name as prod_name', 'products_t.description')
                ->whereBetween('products.price', [$from, $to])
                ->where('products_t.code', $lang)
                ->get();

            return view('products.index',compact('products'));
        }
    }

    public function exportCsvFile()
    {

        $lang = Session::has('locale')?Session::get('locale'):app()->getLocale();
        $products = DB::table('products')
            ->leftjoin('products_t', 'products.id', '=', 'products_t.product_id')
            ->select('products.*', 'products_t.name as prod_name', 'products_t.description')
            ->where('products_t.code', $lang)
            ->get();

        $filename = "file.csv";
        $handle = fopen($filename, 'w+');

        foreach($products->toArray() as $product){
            $data = [];
            foreach($product as $key => $row){
                $data[] = $key .' - '. $row;
            }

            fputcsv($handle, $data);
        }
        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return response()->download($filename, 'file '.date("d-m-Y H:i").'.csv', $headers);


    }

}
