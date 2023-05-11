<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\AttendanceRepository;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    //
    private $repo;

    function __construct(AttendanceRepository $repo)
    {
        $this->repo = $repo;
    }

    function index()
    {
        $years = $this->repo->getYears();

        $months = array(
            1 => 'January', 
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        );
        
        return view('app.attendance.index',['years'=>$years,'months' => $months]);
    }

    public function getPeriods(Request $request)
    {
        $user = Auth::user();

        $pay_type = $this->repo->getEmployeePayType($user->email);

        if($pay_type->pay_type == 3){
            $periods = $this->repo->getPeriods($request->year,$request->month,'weekly');
        }else{
            $periods = $this->repo->getPeriods($request->year,$request->month,'semi');
        }

        return response()->json($periods);
    }

    public function getDTR(Request $request)
    {
        $user = Auth::user();

        $pay_type = $this->repo->getEmployeePayType($user->email);

        if($pay_type->pay_type == 3){
            $data = $this->repo->getWeeklyDTR($user->email,$request->period_id);
        }else{
            $data = $this->repo->getSemiDTR($user->email,$request->period_id);
        }

        return response()->json($data);
        
    }
}
