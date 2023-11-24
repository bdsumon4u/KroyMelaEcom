<?php

namespace App\Http\Controllers\Admin;

use App\Slide;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ImageUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    use ImageUploader;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->view([
            'slides' => Slide::all(),
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
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');
        return Slide::create([
            'is_active' => true,
            'mobile_src' => $this->uploadImage($file, [
                'width' => config('services.slides.mobile.0', 360),
                'height' => config('services.slides.mobile.1', 180),
                'dir' => 'slides/mobile',
            ]),
            'desktop_src' => $this->uploadImage($file, [
                'width' => config('services.slides.desktop.0', 840),
                'height' => config('services.slides.desktop.1',395),
                'dir' => 'slides/desktop',
            ]),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function show(Slide $slide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function edit(Slide $slide)
    {
        return $this->view(compact('slide'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slide $slide)
    {
        $data = $request->validate([
            'title' => 'nullable|max:255',
            'text' => 'nullable|max:255',
            'btn_name' => 'nullable|max:20',
            'btn_href' => 'nullable|max:255',
            'is_active' => 'sometimes|boolean',
        ]);

        $slide->update($data);

        return back()->with('success', 'Slide Has Been Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slide  $slide
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slide $slide)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        Storage::disk('public')->delete(Str::after($slide->mobile_src, 'storage'));
        Storage::disk('public')->delete(Str::after($slide->desktop_src, 'storage'));
        $slide->delete();
        return back()->with('success', 'Slide Has Been Deleted.');
    }
}
