<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Models\Subject;

class Staff extends Model
{
    //protected $guarded = ['id'];
    protected $fillable = ['first_name', 'last_name','address',
        'phone_number','email','subject_id','class','qualification'];
    protected $table = 'staff';

    public function getName()
    {
        return $this->first_name.' '.$this->last_name.' '.$this->other_name;
    }
    public function subject()
    {
        return $this->hasMany(Subject::class, 'id');
    }
    
}
