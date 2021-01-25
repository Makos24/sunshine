<?php

namespace Portal\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Barryvdh\Snappy\Facades\SnappyImage;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Portal\Http\Requests;
use Portal\Models\Position;
use Portal\Models\Result;
use Portal\Models\User;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Portal\Models\Subject;
use Portal\Models\Log;
use Portal\Models\Rate;
use Portal\Models\searchTerm;
use Illuminate\Pagination\Paginator;
use Auth;
use Yajra\Datatables\Facades\Datatables;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin', ['except' => ['index', 'getUserImage','savePic', 'profile',
            'getProfile', 'findStudents', 'getStudents']]);
    }
    public function registerStudent(Request $request)
    {
        $this->validate($request, ['first_name' => 'required|max:20|string',
            'last_name' => 'required|max:20|string',
            'address' => 'required|string',
            'class' => 'required',
            'level' => 'required',
            'student_id' => 'required|unique:users'
        ]);

        User::create([
            'student_id' => $request->input('student_id'),
            'first_name' => $request->input('first_name'),
            'other_name' => $request->input('other_name'),
            'last_name' => $request->input('last_name'),
            'address' => $request->input('address'),
            'level' => $request->input('level'),
            'class' => $request->input('class'),
            'active' => true,
            'is_admin' => false,
            'is_staff' => false,
        ]);

        return back()->with('info', 'Student record saved');
    }

    public function getStudents()
    {
        return view('student.index');
    }

    public function studentsDtable()
    {
        foreach (User::where('name', null)->get() as $user){
            $user->update([
                'name' => $user->first_name." ".$user->last_name." ".$user->other_name
            ]);
        }

        if(session()->get('section') == "primary"){
            $students = User::where('level','>','3')->where('level','<','10')->
            where('active', true)->where('is_staff', false)->where('is_admin', false);
        }elseif(session()->get('section') == "secondary"){

            $students = User::where('level','>','9')->where('level','<','16')->
            where('active', true)->where('is_staff', false)->where('is_admin', false);
        }else{
            return redirect('/start');
        }



        return Datatables::of($students)
            ->addColumn('gender', function ($user){
                if($user->gender == 1){
                    return 'Male';
                }elseif($user->gender == 2){
                    return 'Female';
                }else{
                    return '';
                }
            })->addColumn('class', function ($user){
                return $this->getClassName($user->level).''.$user->class;
            })
            ->addColumn('action', function ($user) {
                $url1 = url('/result/add/'.$user->id);
                $url2 = url('/profile/'.$user->id);
                $url3 = url('/deactivate/'.$user->id);
                return view('partials.students', compact('url1', 'url2', 'url3','user'));
            })->removeColumn('id')->make(true);

    }

    public function studentsByClass(Request $request)
    {
        $students = User::where('level', $request->search)->get();
        if(!$students){

            return back()->with('info', 'Student\'s record not found');
        }
        return view('student.index', compact('students', 'students'));
    }
    public function studentsByLevel($level)
    {
        $students = User::where('level', $level)->get();
        if(!$students){
            session()->flash('info', 'Students record not found');
            return back();
        }
        return view('student.index', compact('students', 'students'));
    }
    public function studentById($studentId)
    {
        $student = User::where('student_id', $studentId)->first();
        if(!$student){
            session()->flash('info', 'Student record not found');
            return back();
        }
        return view('student.profile', compact('student', 'student'));
    }
    public function findStudents(Request $request)
    {
        //$this->validate($request, ['search' => 'required']);
        $search = $request->input('search');
        $piece = explode(" ", $search);
        if(!isset($piece[1])){
            $piece[1] = 0;
        }
        if(session()->get('section') == "primary"){
            $students = User::where('student_id', $search)->orWhere('first_name','LIKE', "%{$piece[0]}%")
                ->orWhere('last_name','LIKE', "%{$piece[1]}%")->orWhere('last_name','LIKE', "%{$piece[0]}%")
                ->orWhere('other_name','LIKE', "%{$piece[0]}%")->orWhere('level',$this->getClass($search))
                ->where('level','>','3')->where('level','<','10')->where('active', true)->where('is_staff', false)->where('is_admin', false)->paginate(40);
        }else if(session()->get('section') == "secondary"){
            $students = User::where('student_id', $search)->orWhere('first_name','LIKE', "%{$piece[0]}%")
                ->orWhere('last_name','LIKE', "%{$piece[1]}%")->orWhere('last_name','LIKE', "%{$piece[0]}%")
                ->orWhere('other_name','LIKE', "%{$piece[0]}%")
                ->orWhere('level',$this->getClass($search))->where('level','>','9')->where
                ('level','<','16')->where('active', true)->where('is_staff', false)->where('is_admin', false)->paginate(40);
        }else{
            return redirect('/start');
        }

        if(!count($students)){
            return back()->with('info', 'No Students found');
        }
        $students->setPath('/portal/searchstudent?search='.$request->search);

        return view('student.index', compact('students'));

    }

    public function getRegister()
    {
        return view('student.newstudent');
    }
    public function savePicture($username, Request $request)
    {
        $student = User::where('first_name', $username)->first();
        if(!$student){

            return back()->with('info', 'User record not found');
        }
        $this->validate($request, ['image' => 'required']);
        $old_name = $student->first_name;
        $filename = $student->first_name . '-' . $student->id . '.jpg';
        $old_filename = $old_name . '-' . $student->id . '.jpg';
        $update = false;
        if (Storage::disk('students')->has($old_filename)) {
            $old_file = Storage::disk('students')->get($old_filename);
            Storage::disk('students')->put($filename, $old_file);
            $update = true;
            session()->flash('info', 'Picture exists');
        }

        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
            session()->flash('info', 'Replaced');
        }
        Storage::disk('students')->put($filename, file_get_contents($request->file('image')->getRealPath()));
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Uploaded Picture '.$filename,
        ]);

        return back()->with('info', 'Picture Saved');
    }
    public function savePic(Request $request)
    {
        $student = User::where('student_id', $request->id)->first();
        if(!$student){
            session()->flash('info', 'Student record not found');
            return response()->json(array('info' => 'Record not found'));
        }
        //$this->validate($request, ['image' => 'required']);
        $old_name = $student->first_name;
        $filename = $student->first_name . '-' . $student->id . '.jpg';
        $old_filename = $old_name . '-' . $student->id . '.jpg';
        $update = false;
        if (Storage::disk('students')->has($old_filename)) {
            $old_file = Storage::disk('students')->get($old_filename);
            Storage::disk('students')->put($filename, $old_file);
            $update = true;
            //return response()->json(array('info' => 'Picture exists'));
        }
        if ($update && $old_filename !== $filename) {
            Storage::delete($old_filename);
            response()->json(array('info', 'Image Replaced'));
        }
        Storage::disk('students')->put($filename, file_get_contents(Input::file('image')->getRealPath()));
        $student->update([
            'image' => $filename,
        ]);
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Uploaded Picture '.$filename,
        ]);
        return response()->json(array('info' => 'Picture Saved'));
    }
    public function getUserImage($filename)
    {
        $file = Storage::disk('students')->get($filename);
        return new Response($file, 200);
    }
    public function getEdit($studentId)
    {
        $student = User::where('id', $studentId)->first();
        if(!$student){

            return back()->with('info', 'User record not found');
        }
        //dd($student);
        return view('student.edit', compact('student', 'student'));
    }
    public function postEdit(User $student, Request $request)
    {
        $this->validate($request, ['first_name' => 'required|max:20|string',
            'last_name' => 'required|max:20|string',
            'address' => 'required|string',
            'class' => 'required',
            'level' => 'required',
            'email' => 'email',
            'phone_number' => 'digits:11',
        ]);

        $student->update(
            ['first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'other_name' => $request->input('other_name'),
                'address' => $request->input('address'),
                'level' => $request->input('level'),
                'class' => $request->input('class'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),]);
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Updated '.$student->student_id.'\'s records',
        ]);
        return back()->with('info', 'Students record Updated');
    }
    public function editStudent(Request $request){
        $student = User::where('student_id', $request->input('student_id'))->first();
        //return response()->json($request);
        if(!$student){
            return response()->json(array('info' => 'Student Not Found'));
        }
        $student->update(
            ['first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'other_name' => $request->input('other_name'),
                'address' => $request->input('address'),
                'level' => $request->input('level'),
                'class' => $request->input('class'),
                'religion' => $request->input('religion'),
                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
                'dad_number' => $request->input('dad_number'),
                'mum_number' => $request->input('mum_number'),]);

        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Updated '.$student->student_id.'\'s records',
        ]);
        return back()->with('info', 'Students record Updated');

        //return response()->json(array('info' => 'User Record Updated'));
    }
    public function getClass($text)
    {
        if($text == 'nur 1' || $text == 'nur1' || $text == 'nursery1' || $text == 'nursery 1'){
            return 1;
        }
        if($text == 'nur 2' || $text == 'nur2' || $text == 'nursery2' || $text == 'nursery 2'){
            return 2;
        }
        if($text == 'nur 3' || $text == 'nur3' || $text == 'nursery3' || $text == 'nursery 3'){
            return 3;
        }
        if($text == 'pri 1' || $text == 'pri1' || $text == 'primary1' || $text == 'primary 1'){
            return 4;
        }
        if($text == 'pri 2' || $text == 'pri2' || $text == 'primary2' || $text == 'primary 2'){
            return 5;
        }
        if($text == 'pri 3' || $text == 'pri3' || $text == 'primary3' || $text == 'primary 3'){
            return 6;
        }
        if($text == 'pri 4' || $text == 'pri4' || $text == 'primary4' || $text == 'primary 4'){
            return 7;
        }
        if($text == 'pri 5' || $text == 'pri5' || $text == 'primary5' || $text == 'primary 5'){
            return 8;
        }
        if($text == 'pri 6' || $text == 'pri6' || $text == 'primary6' || $text == 'primary 6'){
            return 9;
        }
        if($text == 'JSS 1' || $text == 'JSS1' || $text == 'jss1' || $text == 'jss 1'){
            return 10;
        }
        if($text == 'JSS 2' || $text == 'JSS2' || $text == 'jss2' || $text == 'jss 2'){
            return 11;
        }
        if($text == 'JSS 3' || $text == 'JSS3' || $text == 'jss3' || $text == 'jss 3'){
            return 12;
        }
        if($text == 'SS 1' || $text == 'SS1' || $text == 'ss1' || $text == 'ss 1'){
            return 13;
        }
        if($text == 'SS 2' || $text == 'SS2' || $text == 'ss2' || $text == 'ss 2'){
            return 14;
        }
        if($text == 'SS 3' || $text == 'SS3' || $text == 'ss3' || $text == 'ss 3'){
            return 15;
        }
    }

    public function getUploadStudents()
    {
        return view('student.upload');
    }

    public function postUploadStudents(Request $request)
    {

        $this->validate($request, [
            'class' => 'required',
            'div' => 'required|alpha|max:1',
        ]);

        $students = User::where('active', true)->where('level', $request->class)
            ->where('class', $request->div)->orderBy('student_id', 'asc')->get();

        return view('student.emails', compact('students'));
    }

    public function getProfile($studentId)
    {
        $student = User::with('positions','results.subject')->where('id', $studentId)->first();
        if(!$student){
            return back()->with('info', 'Student not found');
        }
        //$results = Result::with('subject')->where('student_id', $student->student_id)->orderBy('level')->get();
        $results = $student->results->sortBy('level');

        return view('student.profile', compact('results','student'));
    }
    public function grade($total)
    {
        if($total > 79){
            return 'A';
        }elseif ($total > 59 && $total < 80){
            return 'B';
        }elseif ($total > 49 && $total < 60){
            return 'C';
        }elseif ($total > 39 && $total < 50){
            return 'D';
        }elseif($total < 40){
            return 'F';
        }
    }
    public function remark($grade)
    {
        if($grade >= 80){
            return 'Excellent';
        }elseif($grade >= 70 && $grade < 80 ){
            return 'Very Good';
        }elseif ($grade >= 60 && $grade < 70){
            return 'Good';
        }elseif ($grade >= 50 && $grade < 60){
            return 'Credit';
        }elseif ($grade >= 40 && $grade < 50){
            return 'Fair';
        }else{
            return 'Poor';
        }
    }
    public function getProfiles(){
        if(session()->get('section') == "primary"){
            $students = User::where('level','>','3')->where('level','<','10')->where('active', true)->where('is_staff', false)->where('is_admin', false)
                ->orderBy('first_name', 'asc')->paginate(12);
        }else if(session()->get('section') == "secondary"){
            $students = User::where('level','>','9')->where('level','<','16')->where('active', true)->where('is_staff', false)->where('is_admin', false)
                ->orderBy('first_name', 'asc')->paginate(12);
        }else{
            return redirect('/start');
        }
        return view('student.profiles', compact('students'));
    }

    public function findProfile(Request $request)
    {
        //$this->validate($request, ['search' => 'required']);
        $search = $request->input('search');
        $piece = explode(" ", $search);
        if(!isset($piece[1])){
            $piece[1] = 0;
        }
        if(session()->get('section') == "primary"){
            $students = User::where('student_id', $search)->orWhere('first_name','LIKE', "%{$piece[0]}%")
                ->orWhere('last_name','LIKE', "%{$piece[1]}%")->orWhere('last_name','LIKE', "%{$piece[0]}%")
                ->orWhere('other_name','LIKE', "%{$piece[0]}%")->orWhere('level',$this->getClass($search))
                ->where('level','>','3')->where('level','<','10')->where('active', true)->where('is_staff', false)->where('is_admin', false)->paginate(12);
        }else if(session()->get('section') == "secondary"){
            $students = User::where('student_id', $search)->orWhere('first_name','LIKE', "%{$piece[0]}%")
                ->orWhere('last_name','LIKE', "%{$piece[1]}%")->orWhere('last_name','LIKE', "%{$piece[0]}%")
                ->orWhere('other_name','LIKE', "%{$piece[0]}%")->orWhere('level',$this->getClass($search))
                ->where('level','>','9')->where('level','<','16')->where('active', true)->where('is_staff', false)->where('is_admin', false)->paginate(12);
        }else{
            return redirect('/start');
        }

        if(!count($students)){
            return back()->with('info', 'No Students found');
        }
        $students->setPath('/portal/searchprofile?search='.$request->search);
        return view('student.profiles', compact('students'));

    }
    public function getPromote(Request $request)
    {
        if ($request->has('search')){
            $students = User::where('level', $request->search)
                ->where('active', true)->where('is_staff', false)
                ->where('is_admin', false)->paginate(60);

        }
        return view('student.promote', compact('students'));
    }

    public function saveStudent(Request $request)
    {
        try{
            $val = $this->validate($request,
                ['first_name' => 'required|max:20|alpha',
                    'last_name' => 'required|max:20|alpha',
                    'address' => 'required|string',
                    'class' => 'required',
                    'level' => 'required',
                    'gender' => 'required',
                    'religion' => 'required',
                    'dob' => 'required',
                    'reg_date' => 'required',
                    'dad_number' => 'required',
                    'mum_number' => 'required',
                    'student_id' => 'required|string|unique:users',
                ]);
            User::create([
                'student_id' => $request->student_id,
                'first_name' => $request->first_name,
                'other_name' => $request->inputother_name,
                'last_name' => $request->last_name,
                'name' => $request->first_name.' '.$request->last_name.' '.$request->other_name,
                'address' => $request->address,
                'level' => $request->level,
                'class' => $request->class,
                'email' => $request->student_id,
                'password' => bcrypt($request->first_name),
                'gender' => $request->gender,
                'religion' => $request->religion,
                'dob' => $request->dob,
                'reg_date' => $request->reg_date,
                'dad_number' => $request->dad_number,
                'mum_number' => $request->mum_number,
                'active' => true,
                'is_admin' => false,
                'is_staff' => false,
            ]);
            Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'Created Student with ID '.$request->student_id,
            ]);
            //return back()->with('info', 'Students record Updated');
            return response()->json(array('sms' => 'Student Record Saved'));

        }catch (Exception $e){
            return response()->json($val);
        }
    }

    public function checkID(Request $request)
    {
        try{
            $std = User::where('student_id', $request->id)->first();
            if($std){
                return response()->json($std);
            }
            return response()->json(null);

        }catch (Exception $e){
            return response()->json($e);
        }
    }
    public function postPromote(Request $request)
    {
        $d = array();
        $i = 0;
        foreach ($request->all() as $req){
            $student = User::where('id', $req)->first();
            $student->update([
                'level' => $student->level+1,
            ]);
            Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'Promoted '.$student->student.' by one class',
            ]);
            $d[$i++] = $req;
        }
        //return back();
        return response()->json($d);
    }
    public function profileJSON(Request $request)
    {
        try{
            if($request->ajax()){

                $student = User::where('id', $request->id)->first();
                if(!$student){
                    return response()->json(null);
                }
                $gen = '';
                $religion = '';
                if($student->gender == null){
                    $gen = '';
                }if ($student->gender == 1){
                    $gen = "Male";
                }if ($student->gender == 2){
                    $gen = "Female";
                }if($student->religion == null){
                    $religion = '';
                }if ($student->religion == 1){
                    $religion = "CHRISTIAN";
                }if ($student->religion == 2){
                    $religion = "ISLAM";
                }
                $data = array('fname' => $student->first_name, 'lname' => $student->last_name, 'oname' =>
                    $student->other_name, 'name' => $student->getName(), 'clas' => $student->getClass(), 'dob' => $student->dob,
                    'student_id' => $student->student_id, 'email' => $student->email, 'gender' => $student->gender, 'phone'
                    => $student->phone, 'address' => $student->address, 'div' => $student->class, 'level' =>
                        $student->getClassName($student->level), 'lev' => $student->level, 'gen' => $gen, 'image' =>
                        $student->image, 'dad_number' => $student->dad_number, 'mum_number' => $student->mum_number,
                    'religion' => $student->religion, 'rel' => $religion,
                );
                return response()->json($data);
            }
        }catch (Exception $e)
        {
            return response()->json($e);
        }
    }
    public function getGraduates()
    {
        $students = User::where('level', 16)->get();
        return view('graduates.index', compact('students'));
    }
    public function getGraduatesByYear(Request $request)
    {
        $students = User::where('leave_year', $request->input('search'))->
        where('level', '>', 15)->get();
        //dd(count($students));
        if(!count($students)){
            session()->flash('info', 'No Graduates Found for '.$request->input("search").' session');
            $students = User::where('level', 16)->get();
            return view('graduates.index', compact('students'));
        }
        return view('graduates.index', compact('students'));
    }

    public function promoteClass(Request $request)
    {
        $this->validate($request, [
            'class1' => 'required',
            'class2' => 'required',
            'div1' => 'required',
            'div2' => 'required',
        ]);
        $students = User::where('level', $request->input('class1'))
            ->where('class',$request->input('div1'))->where('active', true)->get();
        if(!count($students)){

            return back()->with('info', 'No students to promote');
        }
        foreach ($students as $student){
            $student->update([
                'level' => $request->input('class2'),
                'class' => $request->input('div2'),
            ]);
        }
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Promoted '.$this->getClassName($request->class1).''.$request->div1.' to '
                .$this->getClassName($request->class2).''.$request->div2,
        ]);
        return redirect('/promote')->with('info', $this->getClassName($request->input('class1')).$request->input('div1').
            ' Students promoted to '.$this->getClassName($request->input('class2')).$request->input('div2'));

    }
    public function getClassName($level)
    {
        if($level <= 3 && $level > 0){
            return "NURSERY ".$level;
        }elseif ($level > 3 && $level < 10) {
            return "PRIMARY ".($level - 3);
        }elseif ($level > 9 && $level < 13){
            return "JSS ".($level - 9);
        }elseif ($level > 12 && $level < 16){
            return "SS ".($level - 12);
        }
    }

    public function promoteSelected(Request $request)
    {
        $names = $request->input('names');
        foreach ($names as $name){
            $student = User::where('id', $name)->first();
            $student->update([
                'level' => $request->input('class'),
                'class' => $request->input('div'),
            ]);
//			Log::create([
//		'user_id' => Auth::user()->id,
//		'action' => 'Promoted '.$student->student_id.' to '.$request->class,
//		]);
        }
        return redirect('/promote')->with('info', 'Selected students were promoted successfully');
    }

    public function getGraduate()
    {
        if(session()->get('section') == "primary"){
            $students = User::where('level', 9)->get();
        }else if(session()->get('section') == "secondary"){
            $students = User::where('level', 15)->get();
        }else{
            return redirect('/start');
        }
        return view('graduates.graduate', compact('students'));
    }

    public function doGraduation(Request $request)
    {
        $names = $request->input('names');
        if(session()->get('section') == "primary"){
            foreach ($names as $name){
                $student = User::where('id', $name)->first();
                $student->update([
                    'level' => 16,
                    'leave_year' => $request->input('year'),
                ]);
                Log::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Graduated '.$student->student_id.' from primary ',
                ]);
            }
        }else if(session()->get('section') == "secondary"){
            foreach ($names as $name){
                $student = User::where('id', $name)->first();
                $student->update([
                    'level' => 17,
                    'leave_year' => $request->input('year'),
                ]);
                Log::create([
                    'user_id' => Auth::user()->id,
                    'action' => 'Graduated '.$student->student_id.' from secondary',
                ]);
            }
        }else{
            return redirect('/start');
        }


        return back()->with('info', 'Done');
    }

    public function deactivateStudent($id)
    {
        $student = User::where('id', $id)->first();
        if(!$student){
            return back()->with('info', 'Student not found');
        }
        $student->update([
            'active' => false,
        ]);
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Deactivated '.$student->student_id,
        ]);
        return redirect('/inactive')->with('info', $student->getName().' deactivated');
    }

    public function inactivateStudents(Request $request)
    {
        if(session()->get('section') == "primary"){
            if ($request->has('search')){
                $students = User::where('active', false)
                    ->primary()->where('student_id', $request->search)
                    ->orWhere('name','LIKE', "%{$request->search}%")->paginate(20);
            }else{
                $students = User::where('active', false)->primary()->paginate(20);
            }
        }else if(session()->get('section') == "secondary"){
            if ($request->has('search')){
                $students = User::where('active', false)
                    ->secondary()->where('student_id', $request->search)
                    ->orWhere('name','LIKE', "%{$request->search}%")->paginate(20);
            }else{
                $students = User::where('active', false)->secondary()->paginate(20);
            }
        }else{
            return redirect('/start');
        }
        return view('student.inactive', compact('students'));
    }



    public function activateStudent($id)
    {
        $student = User::where('id', $id)->first();
        if(!$student){

            return back()->with('info', 'Student not found');
        }
        $student->update([
            'active' => true,
        ]);
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Reactivated '.$student->student_id,
        ]);
        return back()->with('info', $student->student_id.' Reactivated');

    }

    public function promoteStudent(Request $request)
    {
        $student = User::where('id', $request->input('id'))->first();
        if(!$student){

            return back()->with('info', 'No student to promote');
        }
        $student->update([
            'level' => $request->input('class'),
            'class' => $request->input('div'),
        ]);
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Promoted '.$student->student_id,
        ]);
        return back()->with('info', 'Student promoted');
    }

    public function exportScoreSheet(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        $pdf = \PDF1::loadView('pdf.scoresheet', ['students' => $students, 'class' => $cname]);
        return $pdf->stream($cname.'.pdf');
    }
    public function ScoreSheetPrint(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        return view('pdf.scoresheet', ['students' => $students, 'class' => $cname]);
    }

    public function getClassSheet(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('is_staff', false)->where('is_admin', false)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){
            return back()->with('info', 'No students found');
        }
        if(session()->get('section') == "primary"){
            $subjects = Subject::where('section','primary')->get();
        }else if(session()->get('section') == "secondary"){
            if($level >= 10 && $level < 13){
                $subjects = Subject::where('section','secondary')->where('sub_section', 1)->get();
            }else if($level >= 13 && $level < 15){
                $subjects = Subject::where('section','secondary')->where('sub_section', 2)->get();
            }

        }else{
            return redirect('/start');
        }

        $pdf = \PDF::loadView('pdf.classsheet',
            ['students' => $students, 'class' => $cname, 'subjects' => $subjects]);
        $pdf->setPaper('a4')->setOrientation('landscape');
        return $pdf->inline($cname.'.pdf');

    }

    public function bioData(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('is_staff', false)->where('is_admin', false)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        return view('pdf.biodata', ['students' => $students, 'class' => $cname]);
    }

    public function exportScoreSheetExcel(Request $request)
    {
        $level = $request->input('class');
        $class = $request->input('div');
        $cname = $this->getClassName($level).$class;
        $students = User::where('active', true)->where('is_staff', false)->where('is_admin', false)->where('level', $level)->where('class', $class)->get();
        if(!count($students)){

            return back()->with('info', 'No students found');
        }
        Excel::create('ScoreSheet', function($excel) use($students, $cname){

            $excel->sheet('Score', function($sheet) use($students, $cname) {

                $sheet->loadView('pdf.scoresheet', ['students' => $students, 'class' => $cname]);

            });
        })->export('xls');
    }

    public function getScoreSheet()
    {
        return view('pdf.index');
    }
    public function getScoreSheetPrimary()
    {
        return view('pdf.index');
    }
    public function getScoreSheetSecondary()
    {
        return view('pdf.index');
    }

    public function tStuff($studentId)
    {
        $student = User::with('positions', 'attendances','rates','results')
            ->where('id', $studentId)->first();
        $results = $student->results;
        return compact('student', 'results');
    }

    public function printTranscript($studentId)
    {
        return view('pdf.transcript', $this->tStuff($studentId));
        //$pdf->inline();
    }

    public function getTranscriptPdf($studentId)
    {

        $pdf = \PDF::loadView('pdf.transcript', $this->tStuff($studentId));
        return $pdf->inline($studentId.'.pdf');
    }

    public function getTranscriptExcel($studentId)
    {
        Excel::create($studentId.'-Transcript', function($excel) use($studentId){
            $excel->sheet('New sheet', function($sheet) use($studentId) {
                $sheet->loadView('pdf.transcript', $this->tStuff($studentId));
            });
        })->export('xls');
    }

    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

    public function deleteStudent($id)
    {
        $student = User::where('id',$id)->first();
        $st = $student->student_id;
        $result = Result::where('student_id', $student->student_id)->delete();
        $position = Position::where('student_id', $student->student_id)->delete();
        $student = User::where('id',$id)->delete();
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Deleted '.$st.'\'s Records',
        ]);

        return back()->with('info', 'Student Records Deleted');
    }
    public function index()
    {
        return view('student.page');
    }
    public function profile()
    {
        $results = array();
        $grades = array();
        $remarks = array();
        $totals = array();
        $all = array();
        $position = array();
        $no = array();
        $marks = array();
        $avg = array();
        $student = User::where('id', Auth::user()->id)->first();
        if(!$student){

            return back()->with('info', 'Student not found');
        }
        for($k = 1; $k <= $student->level; $k++) {
            for ($i = 1; $i < 4; $i++) {
                $results[$k][$i] = DB::select('
                    select p.student_id, p.ca1, p.ca2, p.exam, p.subject_id, p.term, p.session, p.position, c.title from results
                            as p, subjects as c where p.student_id=? and p.subject_id=c.id
                             and p.term=? and p.class=? ORDER BY p.subject_id ASC', [$student->student_id, $i, $k]);
            }

        }
        //dd($results[1][1][0]->session);
        for ($k = 1; $k <= $student->level; $k++){
            for ($i = 1; $i <= count($results[$k]); $i++) {
                for ($j = 0; $j < count($results[$k][$i]); $j++) {
                    $grades[$k][$i][$j] = $this->grade(intval($results[$k][$i][$j]->ca1) + intval($results[$k][$i][$j]->ca2)
                        + intval($results[$k][$i][$j]->exam));
                    $remarks[$k][$i][$j] = $this->remark(intval($results[$k][$i][$j]->ca1) +
                        intval($results[$k][$i][$j]->ca2) + intval($results[$k][$i][$j]->exam));
                    $totals[$k][$i][$j] = (intval($results[$k][$i][$j]->ca1) + intval($results[$k][$i][$j]->ca2) +
                        intval($results[$k][$i][$j]->exam));
                    //---------------------
                    $marks[$k][$i][$j] = Result::where('term', $i)->where('class', $k)->
                    where('session', $results[$k][$i][$j]->session)->where('subject_id', $results[$k][$i][$j]->subject_id)
                        ->orderBy('position', 'asc')->get();
                    $sum = 0;
                    //dd($marks);
                    foreach ($marks[$k][$i][$j] as $mark){
                        $sum += $mark->total;
                    }
                    //dd($sum/count($marks[$i][$j]));
                    //if($sum > 0 && $marks[$k][$i][$j] > 0){
                    $avg[$k][$i][$j] = round($sum/count($marks[$k][$i][$j]), 1);
                    //}
                    $pos = Position::where('student_id', $student->student_id)->where('level', $k)->
                    where('term', $i)->first();
                    if(isset($pos)){
                        $position[$k][$i] = $this->ordinal($pos->position);
                        $no[$k][$i] = Position::where('level', $k)->where('class', $pos->class)->
                        where('session', $pos->session)->where('term', $i)->count();
                    }
                }
            }
        }
        $data = array('position' => $position, 'no' => $no);
        //dd($marks);

        $all[1] = $grades;
        $all[2] = $remarks;
        $all[3] = $totals;
        $all[4] = $student;
        $all[5] = $marks;
        $all[6] = $avg;

//        if(!count($results[1][1])){
//            session()->flash('info', 'No Results found for this User');
//            return back();
//        }

        return view('student.academics', compact('results','all','data'));
    }

    public function getMany(Request $request)
    {
        $no = $request->input('no');

        return view('student.addmany', compact('no'));
    }
    public function postMany(Request $request)
    {
        $fail = array();

        for($i = 0; $i < count($request->id); $i++){
            $check = User::where('student_id', $request->id[$i])->first();
            if($check){
                $fail[] = $request->first_name[$i].' '.$request->last_name[$i].' '.$request->other_name[$i].', ';
                continue;
            }else{
                User::create([
                    'student_id' => $request->id[$i],
                    'first_name' => $request->first_name[$i],
                    'last_name' => $request->last_name[$i],
                    'other_name' => $request->other_name[$i],
                    'level' => $request->level[$i],
                    'class' => $request->div[$i],
                    'address' => $request->address[$i],
                    'reg_date' => 0,
                    'gender' => $request->gender[$i],
                    'religion' => $request->religion[$i],
                    'dob' => $request->dob[$i],
                    'dad_number' => $request->fathers_mobile[$i],
                    'mum_number' => $request->mothers_mobile[$i],
                    'password' => bcrypt($request->first_name[$i]),
                    'active' => true,
                    'is_admin' => false,
                    'is_staff' => false,
                ]);

            }
        }
        if(count($fail)){
            foreach($fail as $f){
                $fa = $f;
            }
            return redirect('/students/all')->with('info', 'The following were not registered because their Admission numbers already exist '.$f);
        }

        return redirect('/students/all')->with('info', 'students saved successfully');
    }

    public function searchTerm(Request $request){

        $search = searchTerm::where('text','LIKE', "%{$request->search}%")->get();
        dd($search);
    }

    public function saveEmails(Request $request)
    {
        foreach($request->email as $k => $id){

            User::where('student_id', $k)
                ->update([
                    'email' => $id,
                    'alt_email' => $request->alt_email[$k]
                ]);

        }
        return redirect(url('students/all'))->with('info', 'Emails Saved');
    }

    public function exportEmails(Request $request)
    {
        $students = User::where('active', true)->where('level', $request->class)
            ->where('class', $request->div)->orderBy('student_id', 'asc')->get();

        Excel::create('Email List', function($excel) use($students){

            $excel->sheet('Score', function($sheet) use($students) {

                $sheet->loadView('pdf.emails', ['students' => $students]);

            });
        })->export('xls');

    }

    public function exportAllEmails()
    {
        $all = User::where('active', true)->where('student_id','<>',null)
            ->orderBy('student_id', 'asc')->get();

        Excel::create('All Emails',
            function($excel) use($all){
                foreach ($all->groupBy('level') as $j => $students){
                    //dd($students);
                    $excel->sheet($this->getClassName($j), function($sheet) use($students) {

                        $sheet->loadView('pdf.emails-all', array('level_students' => $students) );

                    });
                }

            })->export('xls');
    }
}
