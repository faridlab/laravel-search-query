<?php

namespace SearchQuery\FilterQueryString\Models;

use Illuminate\Database\Eloquent\Model;
use SearchQuery\FilterQueryString\FilterQueryString;

class User extends Model
{
    use FilterQueryString, UserFilters;

    protected $guarded = [];
}
