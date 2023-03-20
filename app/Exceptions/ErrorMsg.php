<?php

namespace App\Exceptions;

class ErrorMsg 
{
    public function  showmsg($code,$e){
        $msg = "";
        switch($code){
            case '23000' :
                $msg = "Duplicate entry.";
            break;
        }

        return $msg;
    }
}