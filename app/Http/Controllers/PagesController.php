<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index(){
        $title="Welcome to laravel my dear";
        return view("pages.index",compact('title')); //string passed I don't know why
        //return view("pages.index")->with('tit',$title); //string passed is variable name used in the blade template
    }
    public function about(){
        $title="About Us";
        return view("pages.about")->with('tit',$title);   
    }
    
    public function services(){
        $data=array(
            'title'=>'Services',
            'services'=> ['Web design', 'Web development', 'Programming basics']
        );
        return view("pages.services")->with($data);   
    }
}
