<?php

namespace App\Http\Controllers\Admin;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view([
            'brands' => Brand::cached(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:brands',
            'slug' => 'required|unique:brands',
        ]);

        Brand::create($data);

        return back()->with('success', 'Brand Has Been Created.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|unique:brands,id,'.$brand->id,
            'slug' => 'required|unique:brands,id,'.$brand->id,
        ]);

        $brand->update($data);

        return back()->with('success', 'Brand Has Been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        $brand->delete();
        return redirect()
            ->action([self::class, 'index'])
            ->with('success', 'Brand Has Been Deleted.');
    }
}
