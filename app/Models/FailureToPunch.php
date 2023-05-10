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
        'biometric_id',
        'ftp_status'
    ];
    
    public function list($biometric_id,$limit)
    {
        $result = FailureToPunch::where('biometric_id',$biometric_id)
                ->orderBy('id','desc')
                ->limit($limit);

        return $result->get();
    }

    public function list2($biometric_id,$limit,$skip)
    {
        
        $result = FailureToPunch::where('biometric_id',$biometric_id)
                ->orderBy('id','desc')
                ->limit($limit)->skip($skip);

        return $result->get();
    }



    public function listForApproval($employee){
        // $result = FailureToPunch::where('biometric_id','!=',$biometric_id)
        $result = DB::table('ftp')->select(DB::raw("ftp.*,employee_names_vw.employee_name"))
                        ->join('employees','ftp.biometric_id','=','employees.biometric_id')
                        ->join('employee_names_vw','employee_names_vw.biometric_id','=','ftp.biometric_id')
                        ->where('ftp.biometric_id','!=',$employee->biometric_id)
                        //->where('employees.division_id',$employee->division_id)
                        ->where('emp_level','>',$employee->emp_level)
                        //->whereNull('ftp_status');
                        ->where('ftp_status','Pending');
        if($employee->emp_level==3 || $employee->emp_level==4){
            $result->where('dept_id',$employee->dept_id);
        }
        if($employee->emp_level==2){
            $result->where('division_id',$employee->division_id);
        }
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
