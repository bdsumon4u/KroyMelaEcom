<?php

namespace App\Http\Controllers\Admin;

use DB;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view([
            'categories' => Category::nested(),
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
            'parent_id' => 'nullable|integer',
            'name' => 'required|unique:categories',
            'slug' => 'required|unique:categories',
        ]);

        Category::create($data);

        return back()->with('success', 'Category Has Been Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'parent_id' => 'nullable|integer',
            'name' => 'required|unique:categories,id,'.$category->id,
            'slug' => 'required|unique:categories,id,'.$category->id,
        ]);

        $category->update($data);

        return back()->with('success', 'Category Has Been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        DB::transaction(function () use ($category) {
            $category->childrens()->delete();
            $category->delete();
        });
        return redirect()->route('admin.categories.index')->with('success', 'Category Has Been Deleted.');
    }
}
