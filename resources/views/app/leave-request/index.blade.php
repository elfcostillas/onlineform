<?php
    use Carbon\Carbon;

    function carbonDate($date){
        return Carbon::createFromFormat('Y-m-d',$date);
        //$docdate = Carbon::createFromFormat('Y-m-d H:i:s.u',$row->DocDate);
    }

    function carbonDate2($date)
    {
        if($date){
            return Carbon::createFromFormat('Y-m-d H:i:s',$date)->format('m/d/Y H:i');
        }
    }
?>
@extends('app.layout')

@section('csslib')
        <!-- <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/icomoon/style.css')}}" rel="stylesheet">
        <link href="{{ asset('assets/plugins/uniform/css/default.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/datepicker3.css') }}" rel="stylesheet"/>
       
        <link href="{{ asset('assets/css/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('js/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
        <link href="{{ asset('kendo/styles/kendo.common.min.css') }}" rel="stylesheet">
        <link href="{{ asset('kendo/styles/kendo.blueopal.min.css') }}" rel="stylesheet"> 
        <link href="{{ asset('theme/assets/sweetalert2/dist/sweetalert2.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/ecaps.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> -->

		<link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('jslib')      
		<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
     

@endsection

@include('app.nav-header')

@section('page-content')
<div class="row">
		<div class="d-grid col">
			<a class="btn btn-primary mb-2 btn-sm" href="{{url('leave-request/create')}}" type="button">File Leave</a>
		</div>	
	
	</div>
    @foreach($list as $l)
        <div class = "card mystyle mb-2">
            <div class="card-header" >  
               
               <b> {{ carbonDate($l->date_from)->format('m/d/Y') }} - {{ carbonDate($l->date_to)->format('m/d/Y') }}  </b>
            
            </div>
            <div class="card-body mystyle" > 
                <b> Transaction ID : </b> {{ $l->id }} <br>                
                <b> Reason : </b> {{ $l->remarks }} <br>                
                <b> Type : </b> {{ $l->leave_type }} <br>
                <b> Document Status : </b> {{ $l->document_status}} <br>
                <b> With Pay : </b> {{ round($l->with_pay/8,2) }} <br>
                <b> Without Pay : </b> {{ round($l->without_pay/8,2) }} <br>
                <b> Request Status : </b> <b> <span style="color:{{ ($l->acknowledge_status=='Approved') ? 'green' : 'red'  }}">{{ $l->req_status}}</span> </b> <br>
                <b> HR Received : </b> {{ carbonDate2($l->received_time) }}
              
            </div>
        </div>
    @endforeach
@endsection