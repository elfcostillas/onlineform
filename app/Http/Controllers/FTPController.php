<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FailureToPunch as FTP;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Exceptions\ErrorMsg;

class FTPController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $list = FTP::list($user->email,10);

        return view('app.ftp.index',['list' => $list]);
    }

    public function create(Request $request)
    {   
        $schedules =  FTP::sched();
      
        return view('app.ftp.create',['schedules' => $schedules]);
    }

    public function saveCreate(Request $request)
    {   
        $errMsg = new ErrorMsg();

        $user = Auth::user();
        $ftp_date = Carbon::createFromFormat('m/d/Y',$request->input('ftp_date'));

        $data = array(
            'ftp_date' => $ftp_date->format('Y-m-d'),
            'ftp_time' => $request->input('ftp_time'),
            'ftp_state' => 'C/'.$request->input('ftp_state'),
            'ftp_remarks' => $request->input('ftp_remarks'),
            'ftp_type' => $request->input('ftp_type'),
            'encoded_on' => now(),
            'biometric_id' => $user->email

        );
        try {
            $result = FTP::create($data);
        }catch(\Exception $e){
          
            $msg = $errMsg->showmsg($e->getCode(),$e);
            //return (object) array('error' =>$msg );
            return redirect()->back()->withErrors(['msg'=>$msg])->withInput();  
        }

        if($result){
            //dd($result->id);
            $user = Auth::user();
            $list = FTP::list($user->email,10);

            return view('app.ftp.index',['list' => $list]);
        }
    }

    public function getSched(Request $request)
    {
        $schedules = ($request->type == 'In') ?  FTP::sched() : FTP::schedout();

        return response()->json($schedules);
    }

    public function sendSMS()
    {
        try{
            $basic  = new \Vonage\Client\Credentials\Basic("6737887a", "ruQiIBv7OFRCZFvw");
            $client = new \Vonage\Client($basic);

            // $basic  = new \Nexmo\Client\Credentials\Basic(getenv("NEXMO_KEY"), getenv("NEXMO_SECRET"));
            // $client = new \Nexmo\Client($basic);

            $receiverNumber = "+639150153671";
            $message = "This is testing from ItSolutionStuff.com";

            $message = $client->message()->send([
                'to' => $receiverNumber,
                'from' => 'Vonage APIs',
                'text' => $message
            ]);

            dd('SMS Sent Successfully.',$message);
                
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }


    }
}
