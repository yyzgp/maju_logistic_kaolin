<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\Page;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $company = CompanySetting::first();
        return view('welcome', compact('company'));
    }

    public function aboutUs()
    {
        $page = Page::findBySlug("about-us");
        $company = CompanySetting::first();
        $page->banner  = isset($page->banner) ? asset('storage/uploads/pages/' . $page->slug . '/' . $page->banner) : asset("assets/images/background/default-bg.gif");
        return view('about-us', compact('company', 'page'));
    }

    public function privacyPolicy()
    {
        $page = Page::findBySlug("privacy-policy");
        $company = CompanySetting::first();
        $page->banner  = isset($page->banner) ? asset('storage/uploads/pages/' . $page->slug . '/' . $page->banner) : asset("assets/images/background/default-bg.gif");
        return view('privacy-policy', compact('company', 'page'));
    }

    /**
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        $page = Page::findBySlug("terms-conditions");
        $company = CompanySetting::first();
        $page->banner  = isset($page->banner) ? asset('storage/uploads/pages/' . $page->slug . '/' . $page->banner) : asset("assets/images/background/default-bg.gif");
        return view('terms-and-conditions', compact('company', 'page'));
    }


    public function cookiesPolicy()
    {
        $page = Page::findBySlug("cookies-policy");
        $company = CompanySetting::first();
        $page->banner  = isset($page->banner) ? asset('storage/uploads/pages/' . $page->slug . '/' . $page->banner) : asset("assets/images/background/default-bg.gif");
        return view('cookies-policy', compact('company', 'page'));
    }


    /**
     * @return \Illuminate\View\View
     */
    public function contactUs()
    {
        $page = Page::findBySlug("contact-us");
        $company = CompanySetting::first();
        $page->banner  = isset($page->banner) ? asset('storage/uploads/pages/' . $page->slug . '/' . $page->banner) : asset("assets/images/background/default-bg.gif");
        return view('contact-us', compact('company', 'page'));
    }

    public function saveContactUs(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);




        return redirect()->route('contact-us')->with('success', 'Message sent successfully!');
    }
}
