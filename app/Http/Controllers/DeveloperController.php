<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    public function __construct(){
    	return $this->middleware(['auth']);
    }

    public function index(){
    	return view('developer.index');
    }
}
