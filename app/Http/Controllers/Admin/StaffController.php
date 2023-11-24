<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view([
            'admins' => Admin::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
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
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins',
            'password' => 'required',
        ]);
        $data['password'] = bcrypt($data['password']);

        Admin::create($data);

        return back()->with('success', 'Staff Has Been Created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $staff)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        return $this->view([
            'admin' => $staff,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $staff)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:admins,id,' . $staff->id,
            'password' => 'nullable',
            'is_active' => 'sometimes',
        ]);
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $data['is_active'] = isset($data['is_active']);
        $staff->update($data);

        return back()->with('success', 'Staff Has Been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
