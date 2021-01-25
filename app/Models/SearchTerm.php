<?php

namespace Portal\Models;

use Illuminate\Database\Eloquent\Model;

class SearchTerm extends Model
{
  protected $guarded = ['id'];
  protected $table = 'searchterms';
}
