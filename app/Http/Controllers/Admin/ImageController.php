<?php

namespace App\Http\Controllers\Admin;

use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Traits\ImageUploader;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use ImageUploader;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $request->validate([
            'file' => 'required|image',
        ]);

        $file = $request->file('file');

        return Image::create([
            'disk' => 'public',
            'filename' => $file->getClientOriginalName(),
            'path' => $this->uploadImage($file, [
                'width' => 700,
                'height' => 700,
                'dir' => 'images',
            ]),
            'extension' => $file->guessClientExtension(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        abort_if(request()->user()->role_id, 403, 'Not Allowed.');
        if ($image->products->isNotEmpty()) {
            return request()->expectsJson()
                ? response()->json(['danger' => 'Image Is Used.'])
                : back()->with('danger', 'Image Is Used.');
        }

        // $this->delete();
        $image->delete() && Storage::disk($image->disk)->delete(Str::after($image->path, 'storage'));
        return request()->expectsJson()
            ? response()->json(['success' => 'Image Has Been Deleted.'])
            : redirect()
                ->action([self::class, 'index'])
                ->with('success', 'Image Has Been Deleted.');
    }
}
