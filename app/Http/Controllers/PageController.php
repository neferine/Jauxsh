<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about(){
        return view('pages.about');
    }
    public function terms(){
        return view('pages.terms');
    }
    public function privacy(){
        return view('pages.privacy');
    }
    public function shippingReturn(){
        return view('pages.shipping-returns');
    }
    public function faq(){
        return view('pages.faq');
    }
    public function sizeGuide(){
        return view('pages.size-guide');
    }
    public function contact(){
        return view('pages.contact');
    }

}