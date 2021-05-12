<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title = 'Welcome to the homepage!!';
        //return view('pages.index',compact('title'));
        return view('pages.index')->with('jack',$title);
    }
        public function about(){
            $about = "This is the about page!";
        return view('pages.about')->with('jill',$about);
    }
        public function services(){
        $data = array(
            'title' => 'Services',
            'services' => ['Web Design','Programming','SEO(Search Engine Optimization)']    
        );
        return view('pages.services')->with($data);
    }
}
