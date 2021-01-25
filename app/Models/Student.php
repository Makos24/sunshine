<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    protected $guarded = ['id'];
    protected $table = 'students';
    public function results()
    {
        $this->hasMany(Result::class, 'student_id');
    }
    public function getAvatarUrl()
    {
        return "https:gravatar.com/avatar/{{md5('mail@gmail.com')}}?d=mm";
    }
    public function getClass(){
        if($this->level <= 3){
            return "NURSERY ".$this->level."".$this->class;
        }elseif ($this->level > 3 && $this->level < 10) {
            return "PRIMARY ".($this->level - 3)."".$this->class;
        }elseif ($this->level > 9 && $this->level < 13){
            return "JSS ".($this->level - 9)."".$this->class;
        }elseif ($this->level > 12 && $this->level < 16){
            return "SS ".($this->level - 12)."".$this->class;
        }
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
    public function getName()
    {
        return $this->first_name." ".$this->last_name." ".$this->other_name;
    }
    public function ordinal($number) {
        $ends = array('th','st','nd','rd','th','th','th','th','th','th');
        if ((($number % 100) >= 11) && (($number%100) <= 13))
            return $number. 'th';
        else
            return $number. $ends[$number % 10];
    }
}
