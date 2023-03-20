<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FailureToPunch as FTP;

class LeaveController extends Controller
{
    //
    public function index()
    {
        //$list = FTP::list(10);

        dd($list);
        return view('app.leave-request.index');
    }

    

}
