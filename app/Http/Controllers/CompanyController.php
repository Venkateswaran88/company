<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->paginate(5);
        $isAdmin = Auth::user()->isAdmin();
    
        return view('company.index', compact(['companies', 'isAdmin']))
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
        $products = Product::whereStatus('1')->get();
        return view('company.create', compact('products'));
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
            'email' => 'required|email',
        ]);
        $request = $request->all();
        $company = Company::create($request);
        if (isset($request['products']) && count($request['products'])) {
            $company->products()->attach($request['products']);
        }
        return redirect()->route('company.index')
                        ->with('success', 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        $products = Product::whereStatus('1')->get();
        $companyProductIds = $company->products->pluck('id')->toArray();
        return view('company.edit', compact(['company', 'products', 'companyProductIds']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
        ]);
        $request = $request->all();
        $company->update($request);
        if (isset($request['products']) && count($request['products'])) {
            $company->products()->sync($request['products']);
        } else {
            $company->products()->detach();
        }
    
        return redirect()->route('company.index')
                        ->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $isAdmin = Auth::user()->isAdmin();
        if(!$isAdmin) {
            // send error message
            return false;
        }
        $company->delete();
    
        return redirect()->route('company.index')
                        ->with('success', 'Company deleted successfully');
    }

    public function dashboard()
    {
        $companies = Company::whereStatus('1')->get();
       // dd($companies);
        return view('dashboard', compact('companies'));
    }
}
