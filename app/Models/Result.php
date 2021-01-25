<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = ['id'];
    protected $table = 'results';

    public function student()
    {
        $this->belongsTo(Student::class,'student_id');
    }
    public function subject()
    {
        return $this->hasOne('Portal\Models\Subject', 'id', 'subject_id');
    }


    public function getGradeAttribute()
    {
        if($this->total > 79){
            return 'A';
        }elseif ($this->total > 59 && $this->total < 80){
            return 'B';
        }elseif ($this->total > 49 && $this->total < 60){
            return 'C';
        }elseif ($this->total > 39 && $this->total < 50){
            return 'D';
        }elseif($this->total < 40){
            return 'F';
        }
    }


    public function getRemarkAttribute()
    {
        if($this->total >= 80){
            return 'Excellent';
        }elseif($this->total >= 70 && $this->total < 80 ){
            return 'Very Good';
        }elseif ($this->total >= 60 && $this->total < 70){
            return 'Good';
        }elseif ($this->total >= 50 && $this->total < 60){
            return 'Credit';
        }elseif ($this->total >= 40 && $this->total < 50){
            return 'Fair';
        }else{
            return 'Poor';
        }
    }

    public function allResults()
    {
        $all = Result::where('class', $this->class)
            ->where('div', $this->div)->where('term', $this->term)
            ->where('session', $this->session)->where('subject_id', $this->subject_id)->get();

        return $all;
    }

    public function getClassAverageAttribute()
    {
        $results = $this->allResults();
        $sum = $results->sum('total');
        //$highest = $results->sortByDesc('total');
        //$this->attributes['class_highest'] = $highest->get(0)->total;
        $lowest = $results->sortBy('total');
        $this->attributes['class_lowest'] = $lowest->first()->total;

        return round(($sum/count($results)), 1);
    }

    public function getClassHighestAttribute()
    {
        $high = $this->allResults()->sortBy('total');

        return $high->last()->total;
    }

    public function getPositionsAttribute() {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($this->position % 100) >= 11) && (($this->position%100) <= 13))
            return $this->position. 'th';
        else
            return $this->position. $ends[$this->position % 10];
    }

    public function getTotalAttribute()
    {
        return round((intval($this->ca1)+intval($this->ca2)+intval($this->exam)), 1);
    }


    public function getSubjectTitleAttribute()
    {
        return $this->subject->title;
    }

    public function grade()
    {
        if($this->total() > 79){
            return 'A';
        }elseif ($this->total() > 59 && $this->total() < 80){
            return 'B';
        }elseif ($this->total() > 49 && $this->total() < 60){
            return 'C';
        }elseif ($this->total() > 39 && $this->total() < 50){
            return 'D';
        }elseif($this->total() < 40){
            return 'F';
        }
    }
}
