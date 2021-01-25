<?php

namespace Portal\Http\Controllers;

use Illuminate\Http\Request;

use Portal\Http\Requests;
use Portal\Models\Classes;

class ClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postNewClass(Request $request)
    {
        $this->validate($request,
            ['name' => 'required|unique:classes',
                'section' => 'required']);
        Classes::create($request->all());
        session()->flash('info', 'Class saved');
        return back();
    }
    public function showClasses()
    {
        $classes = Classes::all();
        return view('class.index', compact('classes'));
    }
}
