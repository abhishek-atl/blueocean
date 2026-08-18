<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function rootPage($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        $bookingBlockHtml = View::make('frontend.modules.booking.partials.booking_block')->render();
        return view('frontend.modules.pages.index', [
            'page' => $page,
            'bookingBlockHtml' => $bookingBlockHtml
        ]);
    }
}
