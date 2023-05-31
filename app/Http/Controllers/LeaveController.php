<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\LeaveHeader;
use App\Models\LeaveDetail;
use App\Models\LeaveType;
use App\Models\EmployeeModel;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Collection;

class LeaveController extends Controller
{
    //
    private $repo;
    public function __construct(UserRepository $repo)
    {   
        $this->repo = $repo;
    }


    public function index()
    {
        $user = Auth::user();

        $list = LeaveHeader::list($user->email,10);
      
        return view('app.leave-request.index',['list' => $list]);
    }

    public function create(Request $request)
    {
        $types = LeaveType::all();
        $user = Auth::user();

        $year = now()->format('Y');
        $start = $year.'-01-01';
        $end = $year.'-12-31';

        $consumed = LeaveHeader::getBalance($year,$start,$end,$user->email);
      
        $reliever = EmployeeModel::getEmployeeRelievers($user->email);


        return view('app.leave-request.create',['types' => $types,'reliever' => $reliever,'consumed' => $consumed]);
    }

    public function edit(Request $request)
    {
        //dd($request->input()); {
        //     "date_from" => "05/25/2023"
        //     "date_to" => "05/29/2023"
        //     "emp_reliever" => null
        //     "leave_type" => "VL"
        //     "reason" => "123123123123123123"
        // }

        $year = now()->format('Y');
        $start = $year.'-01-01';
        $end = $year.'-12-31';

        

        $types = LeaveType::all();
        $user = Auth::user();
        $consumed = LeaveHeader::getBalance($year,$start,$end,$user->email);

        $reliever = EmployeeModel::getEmployeeRelievers($user->email);

        $bag = array(
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
            'emp_reliever' => $request->input('emp_reliever'),
            'leave_type' => $request->input('leave_type'),
            'reason' => $request->input('reason'),
        );

        $period = CarbonPeriod::create($this->cdate($request->date_from),$this->cdate($request->date_to));

        if($period){
           
        }else {
            dd($period);
        }

        return view('app.leave-request.edit',['types' => $types,'reliever' => $reliever,'period' => $period, 'bag' => $bag,'consumed' => $consumed]);
    }

    public function cdate($date)
    {
        return Carbon::createFromFormat('m/d/Y',$date);
    }

    public function saveLeave(Request $request)
    {
        
        /*
          "date_from" => "05/01/2023"
            "date_to" => "05/02/2023"
            "emp_reliever" => "203"
            "leave_type" => "UT"
            "reason" => "qweqeqweqwe"
            "d" => array:2 [▼
                "2023-05-01" => array:2 [▼
                "'wpay'" => "4"
                "'wopay'" => null
                ]
                "2023-05-02" => array:2 [▶]
    */

        $user = Auth::user();

        $self = EmployeeModel::findSelf($user->email);

        $array = array(
            'biometric_id' => $user->email,
            'encoded_on' => now(),
            'encoded_by' => $user->email,
            'request_date' => now(),
            'leave_type' => $request->leave_type,
            'date_from'  => $this->cdate($request->date_from)->format('Y-m-d') ,
            'date_to' => $this->cdate($request->date_to)->format('Y-m-d') ,
            'remarks' => $request->reason,
            'acknowledge_status' => 'Pending',
            'acknowledge_time'  => null,
            'acknowledge_by' => null,
            'received_by' => null,
            'received_time' => null,
            'dept_id' => $self->dept_id,
            'division_id' => $self->division_id,
            'job_title_id' => $self->job_title_id,
            'document_status' => 'POSTED',
            'reliever_id' => $request->emp_reliever
        );

        $header_id = LeaveHeader::create($array);

        if($header_id){
            foreach($request->input('details') as $day => $value)
            {
               
                $arrayd = array(
                    'header_id' => $header_id->id,
                    'leave_date' => $day,
                    'is_canceled' => 'N',
                    'time_from' => null,
                    'time_to' => null,
                    'with_pay' => ($value['wpay']==null)? 0 : $value['wpay'],
                    'without_pay' =>  ($value['wopay']==null)? 0 : $value['wopay'],
                );

                LeaveDetail::create($arrayd);

            }
        }        
        
        return redirect('leave-request');
        //return view('app.ftp-approval.index',['list' => $list]);
    }

    public function listForApproval(Request $request)
    {
        $user = Auth::user();
        $emp = $this->repo->getuserLevel($user->email);
       
        if($emp->emp_level<5){
            $list = LeaveHeader::listForApproval($emp);

            return view('app.leave-request.approval',['list' => $list,'msg' => '']);
        }else{
            return view('app.leave-request.approval',['list' => collect(),'msg' => 'Unauhtorized access.']);
        }

    }

    public function approve(Request $request)
    {
        $user = Auth::user();
        $ftp = LeaveHeader::find($request->id); 

        $ftp->acknowledge_status = 'Approved';
        $ftp->acknowledge_time = now();
        $ftp->acknowledge_by = $user->id;

        $ftp->save();

        return true;
    }

    public function deny(Request $request)
    {
        $user = Auth::user();
        $ftp = LeaveHeader::find($request->id); 

        $ftp->acknowledge_status = 'Denied';
        $ftp->acknowledge_time = now();
        $ftp->acknowledge_by = $user->id;
        $ftp->deny_reason = $request->remarks;

        $ftp->save();

        return true;
    }

    

}
