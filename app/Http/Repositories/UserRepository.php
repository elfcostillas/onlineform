<?php

namespace App\Http\Repositories;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository
{
	public function getuserLevel($biometric_id){
		$emp = DB::table('employees')
					->select('biometric_id','emp_level','dept_id','division_id')
					->where('biometric_id',$biometric_id)
					->first();

		return $emp;

	}
}