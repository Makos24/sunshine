<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = ['name', 'section'];
    protected $table = 'classes';
}
