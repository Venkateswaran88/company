<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(5);
        $isAdmin = Auth::user()->isAdmin();
    
        return view('product.index', compact(['products', 'isAdmin']))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        $request->validate([
            'name' => 'required',
        ]);
    
        Product::create($request->all());
     
        return redirect()->route('product.index')
                        ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        $request->validate([
            'name' => 'required',
        ]);
    
        $product->update($request->all());
    
        return redirect()->route('product.index')
                        ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        $product->delete();
    
        return redirect()->route('product.index')
                        ->with('success', 'Product deleted successfully');
    }
}
