<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Portal\Http\Requests;

class LibraryController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }
	public function index(){
		
		
		}
}
