<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDetail extends Model
{
    use HasFactory;

    protected $table = 'leave_request_detail';
    
    protected $primaryKey = 'line_id';

    public $timestamps = false;

    protected $fillable = [
        'header_id',
        'leave_date',
        'is_canceled',
        'time_from',
        'time_to',
        'with_pay',
        'without_pay',
    ];




}
