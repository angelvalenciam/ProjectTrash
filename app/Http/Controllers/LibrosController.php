<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibrosController extends Controller
{
    public function index(){
      return view('content.pages.register');
    }
}
