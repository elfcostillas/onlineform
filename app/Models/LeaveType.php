<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $table = 'leave_request_type';
    
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'leave_type_code',
        'leave_type_desc',

    ];

    
}


/*
leave_request_type
id
leave_type_code
leave_type_desc
*/