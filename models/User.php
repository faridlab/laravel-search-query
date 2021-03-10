<?php

namespace GrammaticalQuery\FilterQueryString\Models;

use Illuminate\Database\Eloquent\Model;
use GrammaticalQuery\FilterQueryString\FilterQueryString;

class User extends Model
{
    use FilterQueryString, UserFilters;

    protected $guarded = [];
}
