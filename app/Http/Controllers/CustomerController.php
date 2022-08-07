<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Language;
use App\Test;
use App\Category;
use App;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locale = isset($_GET['locale']) ? $_GET['locale'] : null;
        if ($locale) {
            $request->session()->put('locale', $locale);
        } else {
            $locale = $request->session()->get('locale', 'en');
        }
        App::setLocale($locale);



        $categories =  Category::getAll($locale);
        $languages  =  Language::select('language', 'locale')->get();
        $testCnt    =  Test::get()->count();
        return view('user.home', [
            'testCnt'      =>   $testCnt,
            'languages'     =>  $languages,
            'categories'    =>  $categories,
            'locale'        =>  $locale
        ]);
    }
    public function testView(Request $request)
    {
        $locale = $request->session()->get('locale', 'en');
        return view('user.test', [
            'testCnt'      =>  null,
            'languages'     =>  null,
            'categories'    =>  null,
            'locale'        => $locale
        ]);
    }
}