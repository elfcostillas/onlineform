<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeModel extends Model
{
    use HasFactory;
    protected $table = 'employees';

    function getEmployees()
    {
        $result = EmployeeModel::select('biometric_id','lastname')
        ->where('exit_status',1);

        return $result->get();
    }

    public function makeAccounts()
    {
        $biometric_ids = DB::table('onlineform_users')->select('email');
        //dd($biometric_ids);
        $result = EmployeeModel::select('biometric_id','lastname','firstname','suffixname')
        ->where('exit_status',1)
        ->whereNotIn('biometric_id',$biometric_ids)
        ->get();

        foreach($result as $emp)
        {
            //echo $emp->biometric_id.' - '. $emp->lastname . '<br>';

            $password = Hash::make($emp->lastname);
            $name = $emp->lastname.', '.$emp->firstname.' '.$emp->suffixname;

            //$str = $emp->lastname ."- insert into onlineform_users(name,email,password) values ('$name',$emp->biometric_id,'$password')";
            $str = " insert into onlineform_users(name,email,password) values ('$name',$emp->biometric_id,'$password');";
            
            echo $str ."<br>";
        }

    }

    public function getEmployeeRelievers($biometric_id)
    {
        //SELECT dept_id FROM employees WHERE biometric_id = 847

        $dept = EmployeeModel::select('dept_id')->where('biometric_id',$biometric_id)->first();

        //dd($dept->dept_id);
        $employees = EmployeeModel::select(DB::raw("biometric_id,concat(lastname,', ',firstname) as emp_name"))
        ->where('dept_id',$dept->dept_id)
        ->where('biometric_id','!=',$biometric_id)
        ->where('exit_status','=',1)
        ->get();
    
        return $employees;
    }

    public function findSelf($biometric_id){
        $i = EmployeeModel::select('dept_id','division_id','job_title_id')->where('biometric_id',$biometric_id);

        return $i->first();
    }
}
