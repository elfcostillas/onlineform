<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LeaveHeader extends Model
{
    use HasFactory;

    protected $table = 'leave_request_header';
    
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'biometric_id',
        'encoded_on',
        'encoded_by',
        'request_date',
        'leave_type',
        'date_from',
        'date_to',
        'remarks',
        'acknowledge_status',
        'acknowledge_time',
        'acknowledge_by',
        'received_by',
        'received_time',
        'dept_id',
        'division_id',
        'job_title_id',
        'document_status',
        'reliever_id',
    ];

    public function list($biometric_id,$limit)
    {
        $from = date('Y-01-01');
        $to = date('Y-12-31');

        $result = DB::table('leave_request_header')
        ->join('leave_request_detail','header_id','=','leave_request_header.id')
        ->select(DB::raw("leave_request_header.*,SUM(with_pay) with_pay,SUM(without_pay) without_pay,IFNULL(acknowledge_status,'Pending') AS req_status"))
        ->where('leave_request_header.biometric_id',$biometric_id)
        ->whereBetween('date_from',[$from,$to])
        ->orderBy('leave_request_header.id','desc')
        ->groupBy('leave_request_header.id','leave_request_header.biometric_id','leave_request_header.encoded_on');

        //->limit($limit);

        /*
        $result = LeaveHeader::where('biometric_id',$biometric_id)
      
        ->orderBy('id','desc')
        ->limit($limit);

        SELECT leave_request_header.*,SUM(with_pay) with_pay,SUM(without_pay) without_pay 
        FROM leave_request_header 
        INNER JOIN leave_request_detail ON header_id = leave_request_header.id
        GROUP BY leave_request_header.id
        */

        return $result->get();
    }

    public function listForApproval($employee)
    {
        $result = DB::table('leave_request_header')->select(DB::raw("leave_request_header.*,employee_names_vw.employee_name,SUM(with_pay) with_pay,SUM(without_pay) without_pay"))
        ->join('employees','leave_request_header.biometric_id','=','employees.biometric_id')
        ->join('employee_names_vw','employee_names_vw.biometric_id','=','leave_request_header.biometric_id')
        ->where('leave_request_header.biometric_id','!=',$employee->biometric_id)
        //->where('employees.division_id',$employee->division_id)
        ->join('leave_request_detail','header_id','=','leave_request_header.id')
        ->where('emp_level','>',$employee->emp_level)
        ->whereNull('acknowledge_time')
       
        ->where('document_status','POSTED');
        if($employee->emp_level==3 || $employee->emp_level==4){
        $result->where('employees.dept_id',$employee->dept_id);
        }
        if($employee->emp_level==2){
        $result->where('employees.division_id',$employee->division_id);
        }

        $result->groupBy('leave_request_header.id');
        $result->groupBy('employee_names_vw.employee_name');
        return $result->get();
    }

    function getBalance($year,$start,$end,$biometric_id){
        $qry = "  SELECT employees.biometric_id,lastname,firstname,suffixname,IFNULL(vacation_leave,0) vacation_leave,IFNULL(sick_leave,0) sick_leave,
        IFNULL(VL_PAY,0) VL_PAY,IFNULL(SL_PAY,0) SL_PAY
        FROM employees LEFT JOIN leave_credits ON leave_credits.biometric_id = employees.biometric_id
        LEFT JOIN (
          SELECT biometric_id,ROUND(SUM(with_pay)/8,2) AS VL_PAY FROM leave_request_header 
              INNER JOIN leave_request_detail ON leave_request_header.id = header_id
          WHERE leave_date BETWEEN '$start' AND '$end'  AND leave_request_header.acknowledge_status = 'Approved' AND document_status = 'POSTED'
          AND with_pay > 0
          AND is_canceled = 'N'
          AND leave_type in ('VL','EL')
          AND leave_request_header.received_by IS NOT NULL
          GROUP BY biometric_id
      ) AS vl ON employees.biometric_id = vl.biometric_id
       LEFT JOIN (
          SELECT biometric_id,ROUND(SUM(with_pay)/8,2) AS SL_PAY FROM leave_request_header 
              INNER JOIN leave_request_detail ON leave_request_header.id = header_id
          WHERE leave_date BETWEEN '$start' AND '$end' AND leave_request_header.acknowledge_status = 'Approved' AND document_status = 'POSTED'
          AND with_pay > 0
          AND is_canceled = 'N'
          AND leave_type = 'SL'
          AND leave_request_header.received_by IS NOT NULL
          GROUP BY biometric_id
      ) AS sl ON employees.biometric_id = sl.biometric_id
        WHERE leave_credits.fy_year = $year and employees.biometric_id = $biometric_id;";

        $result = DB::select($qry);

        return $result;

    }
}
