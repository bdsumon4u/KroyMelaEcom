<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view([
            'pages' => Page::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view();
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
            'title' => 'required',
            'slug' => 'required|unique:pages',
            'content' => 'required',
        ]);

        Page::create($data);

        return redirect()->route('admin.pages.index')->withSuccess('Page Created.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return $this->view();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required',
            'slug' => 'required|unique:pages,id,'.$page->id,
            'content' => 'required',
        ]);

        $page->update($data);

        return redirect()->route('admin.pages.index')->withSuccess('Page Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        $page->delete();
        return back()->withSuccess('Page Deleted.');
    }
}
