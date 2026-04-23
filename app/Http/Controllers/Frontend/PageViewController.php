<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Backend\HomeSliderController;
use App\Http\Controllers\Controller;
use App\Models\AppointmentRequest;
use App\Models\ClientReview;
use App\Models\CompanyService;
use App\Models\HomeSlider;
use App\Models\NewsEvent;
use App\Models\Page;
use Illuminate\Http\Request;

class PageViewController extends Controller
{
    public function home(Request $rqequest)
    {
        return view('frontend.common-pages.home', [
            'services' => CompanyService::where('status' , 1)->take(6)->latest()->get(),
            'newsEvents' => NewsEvent::where('status' , 1)->take(3)->latest()->get(),
            'sliders' => HomeSlider::where('status', 1)->take(4)->latest()->get(),
            'clientReviews' => ClientReview::where('status', 1)->take(5)->latest()->get(),
        ]);
    }
    public function pageView(Request $request, $slug)
    {
        return view('frontend.common-pages.page', [
            'page' => Page::where('slug', $slug)->first(),
            'services' => CompanyService::latest()->get(),
        ]);
    }
    public function contactUs(Request $request)
    {
        return view('frontend.common-pages.contact-us');
    }
    public function serviceDetails(Request $request, $companyServiceSlug)
    {
        return view('frontend.services.service-details', [
            'service' => CompanyService::where('slug', $companyServiceSlug)->first(),
            'services' => CompanyService::latest()->get(),
        ]);
    }
    public function serviceCategories(Request $request)
    {
        return view('frontend.services.service-category', ['services' => CompanyService::where('status', 1)->latest()->get()]);
    }
    public function newsEvents(Request $request)
    {
        return view('frontend.news-events.news-category', [
            'newsEvents'    => NewsEvent::where('status', 1)->latest()->get(),
            'services'      => CompanyService::latest()->get(),
        ]);
    }
    public function newsEventDetails(Request $request, $slug)
    {
        return view('frontend.news-events.news-details', [
            'newsEvent' => NewsEvent::where('slug', $slug)->first(),
            'services'      => CompanyService::latest()->get(),
        ]);
    }

    public function newAppointment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'mobile' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);
        try {
            AppointmentRequest::create($request->all());
            return back()->with('success', 'Thank you! Your request has been submitted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
