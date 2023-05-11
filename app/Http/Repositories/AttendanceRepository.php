<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
	function getYears()
	{
		//SELECT DISTINCT YEAR(dtr_date) FROM edtr ORDER BY dtr_date DESC;
		$result = DB::table('edtr')
					->select(DB::raw('YEAR(dtr_date) as yr'))
					->distinct()
					->orderBy('dtr_date','desc')
					->get();

		return $result;
	}

	function getEmployeePayType($bio_id)
	{
		$result = DB::table('employees')
						->select('pay_type')
						->where('biometric_id',$bio_id);

		return $result->first();
	}

	function getWeeklyDTR($bio_id,$period_id)
	{
		$qry = "SELECT edtr.*,DATE_FORMAT(dtr_date,'%a') as wd,DATE_FORMAT(dtr_date,'%m/%d') as fdate FROM payroll_period_weekly 
		LEFT JOIN edtr ON dtr_date BETWEEN payroll_period_weekly.date_from AND payroll_period_weekly.date_to
		WHERE biometric_id = $bio_id AND payroll_period_weekly.id = $period_id ORDER BY dtr_date ASC";

		$result = DB::select($qry);

		return $result;
	}

	function getSemiDTR($bio_id,$period_id)
	{
		$qry = "SELECT edtr.*,DATE_FORMAT(dtr_date,'%a') as wd,DATE_FORMAT(dtr_date,'%m/%d') as fdate FROM payroll_period 
		LEFT JOIN edtr ON dtr_date BETWEEN payroll_period.date_from AND payroll_period.date_to
		WHERE biometric_id = $bio_id AND payroll_period.id = $period_id ORDER BY dtr_date ASC";

		$result = DB::select($qry);

		return $result;
	}

	public function getPeriods($year,$month,$type)
	{
		//dd($year,$month,$type);

		if($type=='semi'){
			$qry = "SELECT id,CONCAT(DATE_FORMAT(date_from,'%m/%d/%Y'),' - ',DATE_FORMAT(date_to,'%m/%d/%Y')) AS label 
				FROM payroll_period 
				WHERE YEAR(date_from) = $year
				AND MONTH(date_from) = $month";
		} else {
			$qry = "SELECT id,CONCAT(DATE_FORMAT(date_from,'%m/%d/%Y'),' - ',DATE_FORMAT(date_to,'%m/%d/%Y')) AS label 
				FROM payroll_period_weekly
				WHERE YEAR(date_from) = $year
				AND MONTH(date_from) = $month";
		}

		$result = DB::select($qry);
		
		return $result;
	}
	
}