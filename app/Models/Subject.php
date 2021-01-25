<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;
use Portal\Models\Staff;

class Subject extends Model
{
    //protected $guarded = ['id'];
    protected $fillable = ['title', 'section', 'sub_section'];
    protected $table = 'subjects';

    
}
