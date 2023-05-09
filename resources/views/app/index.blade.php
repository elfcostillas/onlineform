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

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JLR </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="{{ url('ftp') }}">FTP</a>
        <a class="nav-link" aria-current="page" href="{{ url('ftp_approval') }}">FTP Approval</a>
        <a class="nav-link" href="{{ url('leave-request') }}">Leave Request</a>
		    <a class="nav-link" href="#" onclick="fnLogOut()" >Logout</a>
      </div>
    </div>
  </div>
</nav>
@endsection

@section('page-content')
  Welcome {{$name}}.
@endsection