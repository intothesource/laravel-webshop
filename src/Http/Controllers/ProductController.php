<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Product;
use App\Product_variant;
use App\Product_variant_i18n;
use App\Discount;
use App\Language;
use App\Category;
use App\Tax;
use Notification;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::all();
        return view('intothesource.webshop.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intothesource.webshop.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $product->tax_group_id = 1;
        // @todo: koppeling maken met i18n tabel via de Translatable Package.
        // $product->$request->input('product.name');

        $product->save();
    }

    /**
     * Don't show resource, but redirect back to index method.edirect back to index method.
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return redirect()->action('ProductController@index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $productVariants    = Product_variant::where('product_id', $product->product_id)->get();
        $languages          = Language::orderBy('order', 'asc')->get();
        $categories         = Category::all();
        $discounts          = Discount::all();
        $taxes              = Tax::all();

        return view('intothesource.webshop.products.edit', compact('product', 'productVariants', 'languages', 'categories', 'discounts', 'taxes') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return ( Product::destroy($product->product_id) ? response()->json(['success' => true]) : response()->json(['success' => false], 422) );
    }
}
