<?php

namespace App\Http\Controllers;

use App\HomeSection;
use App\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
      //  \LaravelFacebookPixel::createEvent('PageView', $parameters = []);
        $slides = cache()->rememberForever('slides', function () {
            return Slide::whereIsActive(1)->get();
        });
        $sections = cache()->rememberForever('homesections', function () {
            return HomeSection::orderBy('order', 'asc')->get();
        });
        return view('index', compact('slides', 'sections'));
    }
}
