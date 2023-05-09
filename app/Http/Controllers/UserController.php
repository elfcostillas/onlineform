<?php

namespace App\Http\Controllers;
use App\Models\EmployeeModel;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function copy()
    {
        $result = EmployeeModel::makeAccounts();

        
    }
}
