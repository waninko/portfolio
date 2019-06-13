<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome To a Blogpage created with Wonderful Laravel!';
        //return view('pages.index', compact('title')); Kan sende parametre på denne måten
        return view('pages.index')->with('title', $title); //dette er den vanligste
    }

    public function about(){
        $title = 'This is the About page! Welcome!';
        return view('pages.about')->with('title', $title);
    }

    public function services(){

        $data = array(
            'title' => 'Get served in these topics:',
            'services' => ['Web Design', 'Programming', 'SEO']
        );

        return view('pages.services')->with($data);
    }

}
