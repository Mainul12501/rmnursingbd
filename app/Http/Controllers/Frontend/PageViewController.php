<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyService;
use Illuminate\Http\Request;

class PageViewController extends Controller
{
    public function home(Request $request)
    {
        return view('frontend.common-pages.home');
    }
    public function pageView(Request $request)
    {
        return view('frontend.common-pages.page');
    }
    public function contactUs(Request $request)
    {
        return view('frontend.common-pages.contact-us');
    }
    public function serviceDetails(Request $request, $companyServiceSlug)
    {
        return view('frontend.services.service-details');
    }
    public function serviceCategories(Request $request)
    {
        return view('frontend.services.service-category');
    }
    public function newsEvents(Request $request)
    {
        return view('frontend.news-events.news-category');
    }
    public function newsEventDetails(Request $request)
    {
        return view('frontend.news-events.news-details');
    }
}
