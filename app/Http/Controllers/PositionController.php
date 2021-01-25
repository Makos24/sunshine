<?php

namespace Portal\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Barryvdh\Snappy\Facades\SnappyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Portal\Http\Requests;
use Portal\Models\Position;
use Portal\Models\Result;
use Portal\Models\Setting;
use Portal\Models\User;
use Portal\Models\Subject;

class PositionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    public function getPosition()
    {
//        $tc = Result::where('level', 11)->where('class', 'C')->where('term', 3)->get();
//        dd($tc);
        return view('position.index');
    }
    public function doPositions($class, $div, $term, $session)
    {
//
        $students = Result::select(DB::raw('DISTINCT student_id'))->
        where('class', $class)->where('div', $div)->where('term',$term)
            ->where('session', $session)->pluck('student_id')->toArray();

          foreach ($students as $k => $position) {
              //dd($position);
            $tot = 0;
          	$cum = 0;
          	$over = 0;
          	$avg = 0;
          	$avg3 = 0;

          	$student = User::where('student_id', $position)->where('active', true)->first();

              if (!$student){
                  continue;
              }

          	$results[$k] = Result::where('student_id', $position)->
          	where('term', $term)->where('session', $session)->where('class', $class)->get();

          	foreach ($results[$k] as $key => $result) {
          		//$tot += intval($result->ca1) + intval($result->ca2) + intval($result->exam);
          		$tot += $result->total;
          		$subject[$k][$key] = $result->subject_id;
            }
          		if(count($results[$k]))
          		$avg = round($tot/count($results[$k]), 2);

          	Position::updateOrCreate(
          	    [
                    'student_id' => $position,
                    'level' => $class,
                    'class' => $div,
                    'term' => $term,
                    'session' => $session,
                ],
                [
                    'total' => $tot,
                    'average' => $avg,
                    'overall_mark' => $over,
                    'overall_avg' => $avg3,
                    'position' => 0,
                    'overall_pos' => 0,
                ]
            );


                    $tot = 0;
                    $cum = 0;
                    $over = 0;
                    $avg = 0;
                    $avg3 = 0;
                    $ft = 0;
                    $st = 0;
                    $tt = 0;
                    if($term == 3){
                      $results[$k] = Result::where('student_id', $position)
                      ->where('session', $session)->where('class', $class)->get();
                      $results = $results[$k]->groupBy('term');
                      if(isset($results[1]))
                    foreach ($results[1] as $key => $result) {
                      //dd($result);
                      $ft += $result->total;
                       }
                       if(isset($results[2]))
                    foreach ($results[2] as $key => $result) {

                      $st += $result->total;

                       }
                       if(isset($results[3]))
                    foreach ($results[3] as $key => $result) {

                      $tt += $result->total;
                       }
                       if(isset($results[1])){
                         $fa = $ft/count($results[1]);
                         }else{
                           $fa = 0;
                           }

                       if(isset($results[2])){

                       $sa = $st/count($results[2]);
                       }else{
                           $sa = 0;
                           }
                       if(isset($results[3])){

                       $ta = $tt/count($results[3]);
                       }else{
                           $ta = 0;
                           }
                       $sum = ($ft+$st+$tt);
                      $avg = round(($fa+$sa+$ta)/($fa == 0 || $sa == 0 ? 2 : 3), 2);

                        Position::updateOrCreate(
                            [
                                'student_id' => $position,
                                'level' => $class,
                                'class' => $div,
                                'term' => $term,
                                'session' => $session,
                            ],
                            [
                                'overall_mark' => ($ft+$st+$tt),
                                'overall_avg' => $avg,
                                'position' => 0,
                                'overall_pos' => 0,
                            ]
                        );

                        /* if($promote){
                            if ($avg >= 40){
                                if ($student->level == $class){
                                    $student->update([
                                        'level' => $student->level + 1
                                    ]);
                                }
                            }
                        } */



        }
          }
//

      	  }

	public function runPositions($class, $div, $term, $session)
	{
	$pos = 1;
	$allPos = array();

	$positions = Position::where('level', $class)->
	where('class', $div)->where('term', $term)->where('session', $session)->orderBy('average', 'desc')->get();
	if(count($positions)) {
        //dd($positions[1]);
        for($i = 0; $i < count($positions); $i++) {
            //$totals[$k] = $position->average;
            $res = $this->getAllResults($positions[$i]->student_id, $class, $term, $session);
            $name = $this->getName($positions[$i]->student_id);
            //dd($res);
            $positions[$i]->update([
                'position' => $pos,
            ]);
            $allPos[$i] = array('name' => $name, 'student' => $positions[$i]->student_id,
                'total_score' => $positions[$i]->total,
                'position' => $positions[$i]->average == $positions[($i > 0 && $i < (count($positions))) ? $i-1 : $i]->average ?
                    $this->ordinal($positions[($i > 0 && $i < (count($positions))) ? $i-1 : $i]->position) : $this->ordinal($pos), 'results' => $res);
		$pos++;
        }
    }
		//third term
		if($term == 3){
			$pos = 1;
			 $positions = Position::where('level', $class)->
        where('class', $div)->where('term', $term)->where('session', $session)->
		orderBy('overall_avg', 'desc')->get();

        if(count($positions)) {
            for($i = 0; $i < count($positions); $i++) {
                if ($i == 0){
                    $positions[$i]->update([
                       'overall_pos' => $pos,
                    ]);
                }else{
                    $positions[$i]->update([
                        'overall_pos' => $positions[$i]->overall_avg == $positions[($i > 0 && $i < (count($positions))) ? $i-1 : $i]->overall_avg ?
                            $positions[($i > 0 && $i < (count($positions))) ? $i-1 : $i]->overall_pos : $pos,
                    ]);
                }

                  //dd($pos);
                $pos++;
            }
            //dd($positions);

        }
			}


		//dd($allPos);

        return $allPos;
    }
    public function getClassName($level)
    {
        if($level <= 3){
            return "NURSERY ".$level;
        }elseif ($level > 3 && $level < 10) {
            return "PRIMARY ".($level - 3);
        }elseif ($level > 9 && $level < 13){
            return "JSS ".($level - 9);
        }elseif ($level > 12 && $level < 16){
            return "SS ".($level - 12);
        }
    }
    public function getPositions(Request $request)
    {
        $class = $request->input('class');
        $div = $request->input('div');
        $term = $request->input('term');
        $session = $request->input('session');
        $this->doPositions($class, $div, $term, $session);
        $data = array('class' => $class, 'div' => $div, 'term' => $term, 'session' => $session,
            'ctitle' => $this->getClassName($class), 'ttitle' => $this->getTerm($term));
        $allPos = $this->runPositions($class, $div, $term, $session);
        if(!count($allPos)){
            return back();
        }
		//dd($allPos);

        return view('position.index', compact('allPos', 'data'));

    }
    public function getAllResults($student, $class, $term, $session)
    {
        $res = Result::where('student_id', $student)->where('class', $class)->where('term', $term)
            ->where('session', $session)->get();
        $return = array();
        foreach ($res as $k => $r){
            $subject = $this->getSubName($r->subject_id);
            $return[$k] = array('subject' => $subject, 'ca' => (intval($r->ca1)+intval($r->ca2)), 'exam' => intval($r->exam));
        }
       // dd($return);
        return $return;
    }
    public function getName($student)
    {
        $name = User::where('student_id', $student)->first();
        if($name)
        return $name->getName();
    }
    public function getSubName($id)
    {
        $sub = Subject::where('id', $id)->first();
		if($sub)
        return $sub->title;
    }

    public function getTerm($t)
    {
        if($t == 1){
            return 'FIRST TERM';
        }elseif ($t == 2){
            return 'SECOND TERM';
        }elseif ($t == 3){
            return 'THIRD TERM';
        }
    }

    public function getCollate()
    {
        return view('position.position');
    }
    public function printPositions($class, $div, $term, $session)
    {
        $pdf = \PDF1::loadView('pdf.position', $this->tStuff($class, $div, $term, $session));
        $pdf->setPaper('A2', 'landscape');
        return $pdf->stream('positions.pdf');

    }

    public function excelPositions($class, $div, $term, $session)
    {
        $school = Setting::where('key','title')->first()->value;
        $this->doPositions($class, $div, $term, $session);
        $allPos = $this->runPositions($class, $div, $term, $session);
        $data[0] = array($school);
        $data[1] = array($this->getTerm($term),' RESULTS FOR ',$this->getClassName($class),' FOR ',
            $session."/".++$session);
        $subjects = array();
        $subjects[0] = "  ";
        //dd($allPos[0]['results']);

            foreach ($allPos[0]['results'] as $subject){
                array_push($subjects, $subject['subject'], " ", " ");
            }

        $title = array();
        $title[0] = "NAMES ";
            foreach ($allPos[0]['results'] as $subject){
                array_push($title, "TCA ", "TE  ", "TCAE");
            }
            array_push($title, "T.MRKS","AVERAGE","POSITION");
        $data[2] = $subjects;
        $data[3] = $title;
        //dd($data);
        foreach ($allPos as $student) {
            $stud = array();
            $stud[0] = $student['name'];
            foreach ($student['results'] as $result){
                array_push($stud, intval($result['ca']),intval($result['exam']),(intval($result['ca'])+intval($result['exam'])));
            }
			if (count($student['results'])){
				if($term == 3){
					array_push($stud, $student['total_score'],
					round($student['total_score']/(count($student['results'])*3), 2), $student['position']);
				//dd($stud);
					}else{
						array_push($stud, $student['total_score'],
					round($student['total_score']/count($student['results']), 2), $student['position']);
				//dd($stud);
					}

				}

            $data[] = $stud;
        }
        Excel::create('Summary', function($excel) use($data) {
            $excel->sheet('summary', function($sheet) use($data) {
                $sheet->fromArray($data,null,'A1',false,false);
            });
        })->export('xls');
    }

    public function getPrintPositions($class, $div, $term, $session)
    {
        return view('pdf.position', $this->tStuff($class, $div, $term, $session));
    }

    public function tStuff($class, $div, $term, $session)
    {
        $this->doPositions($class, $div, $term, $session);
        $allPos = $this->runPositions($class, $div, $term, $session);
        $dat = array('ttitle'=>$this->getTerm($term),'ctitle'=>$this->getClassName($class).$div,
            'session'=>$session);
        $subjects = array();
        $subjects[0] = "  ";
        //dd($allPos);
		$sub = DB::select('SELECT DISTINCT subject_id FROM results WHERE term = '.$term.' AND session = '.$session.' AND class = '.$class.' AND div = "'.$div.'"');

        foreach ($sub as $subject){
			//dd($subject->subject_id);
			$subjct = Subject::find($subject->subject_id);
			if($subjct)
            array_push($subjects, $subjct->title);
        }
        $title = array();
        $title[0] = "NAMES ";
        //array_push($title, "Names", "", "");
        foreach ($sub as $subject){
            array_push($title, "TCA ", "TE  ", "TCAE");
        }
        array_push($title, "T.MRKS","AVERAGE","POSITION");
        $data[1] = $subjects;
        $data[2] = $title;
        //dd($data);
        foreach ($allPos as $student) {
            $stud = array();
            $stud[0] = $student['name'];
			foreach($sub as $subject){
				$result = Result::where('student_id', $student['student'])->where('class', $class)->
				where('term', $term)->where('session', $session)->where('subject_id', $subject->subject_id)
				->first();
				if($result){
					array_push($stud, (intval($result->ca1)+intval($result->ca2)),intval($result->exam),
					($result->total));
					}else{
					array_push($stud, '-','-','-');
					}
				//dd($result);
				}
            //foreach ($student['results'] as $result){
              //  array_push($stud, $result['ca'],$result['exam'],($result['ca']+$result['exam']));
            //}
            if (count($student['results'])){
				if($term == 3){
					array_push($stud, $student['total_score'],
					round($student['total_score']/(count($student['results'])), 2), $student['position']);
				//dd($stud);
					}else{
						array_push($stud, $student['total_score'],
					round($student['total_score']/count($student['results']), 2), $student['position']);
				//dd($stud);
					}

				}
            $data[] = $stud;
        }
        return array('data' => $data, 'dat' => $dat);
    }
    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }

}
