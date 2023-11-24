<?php

namespace App\Http\Controllers\Admin;

use App\MenuItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Menu;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'menu_id' => 'required|integer',
            'name' => 'required',
            'href' => 'required',
        ]);

        MenuItem::create($data);

        return back()->withSuccess('Menu Item Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function show(MenuItem $menuItem)
    {
        return $this->view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuItem $menuItem)
    {
        return $this->view();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        $data = $request->validate([
            'name' => 'required',
            'href' => 'required',
        ]);

        $menuItem->update($data);

        return back()->withSuccess('Menu Item Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuItem  $menuItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MenuItem $menuItem)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        $menuItem->delete();
        return back()->withSuccess('Menu Item Deleted.');
    }
}
