<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class FrontpageController extends Controller
{
    function index()
    {
        $products = DB::table('products')->where([
            ['status', '=', '1']
        ])->get();

        $promo = DB::table('products')->where([
            ['status', '=', '1'],
            ['promo', '=', 'Yes'],
        ])->inRandomOrder()->get();

        $banners = \App\promoBannerSection::all();
        
        $news = DB::table('news')->where([
            ['status', '=', '1']
        ])->limit(2)->orderBy('id', 'desc')->get();

        return view('frontpage', ['banner_top' => $banners, 'products' => $products, 'promo' => $promo, 'news' => $news]);
    }

    function getPage($slugPage)
    {
        $page = DB::table('pages')->where([
            ['slugPage', '=', $slugPage],
            ['status', '=', '1']
        ])->first();

        if ($page == NULL) {
            return redirect()->route('frontpage');
        }

        return view('page', ['page' => $page]);
    }


    function getNews()
    {
        $newss = DB::table('news')->where([
            ['status', '=', '1']
        ])->orderBy('id', 'desc')->get();

        return view('news-index', ['newss' => $newss]);
    }

    function getDetailNews($slugNews)
    {
        $news = DB::table('news')->where([
            ['slugNews', '=', $slugNews],
            ['status', '=', '1']
        ])->first();

        if ($news == NULL) {
            return redirect()->route('frontpage');
        }

        return view('news-detail', ['news' => $news]);
    }

}