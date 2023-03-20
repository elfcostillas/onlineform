<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FailureToPunch extends Model
{
    use HasFactory;

    protected $table = 'ftp';
    
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'ftp_date',
        'ftp_time',
        'ftp_state',
        'ftp_remarks',
        'ftp_type',
        'encoded_on',
        'biometric_id'
    ];
    
    public function list($biometric_id,$limit)
    {
        $result = FailureToPunch::where('biometric_id',$biometric_id)
                ->limit($limit);

        return $result->get();
    }

    public function sched()
    {
        $result = FailureToPunch::select(DB::raw("time_in,
            FLOOR((TIME_TO_SEC(time_in) % TIME_TO_SEC('12:00'))/3600) AS hrs,
            LPAD(FLOOR((TIME_TO_SEC(time_in) % TIME_TO_SEC('1:00'))/60),2,0) AS mins,
            CASE 
                WHEN TIME_TO_SEC(time_in) < TIME_TO_SEC('12:00') THEN 'A.M.'
                ELSE 'P.M.'
            END AS ampm"
        ))
        ->distinct()
        ->from('work_schedules')
        ->orderBy('time_in','asc');

        return $result->get();
    }

    public function schedout()
    {
        $result = FailureToPunch::select(DB::raw("time_out as time_in,
            FLOOR((TIME_TO_SEC(time_out) % TIME_TO_SEC('12:01'))/3600) AS hrs,
            LPAD(FLOOR((TIME_TO_SEC(time_out) % TIME_TO_SEC('1:00'))/60),2,0) AS mins,
            CASE 
                WHEN TIME_TO_SEC(time_out) < TIME_TO_SEC('12:00') THEN 'A.M.'
                ELSE 'P.M.'
            END AS ampm"
        ))
        ->distinct()
        ->from('work_schedules')
        ->orderBy('time_out','asc');

        return $result->get();
    }
}
