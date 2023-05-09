<?php
	use Carbon\Carbon;
?>

@extends('app.layout')

@section('csslib')

		<!-- <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> -->
@endsection

@section('jslib')      
		<!-- <script src="{{ asset('jquery/jquery-3.5.1.min.js') }}"></script>
		<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script> -->
@endsection

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JLR - Failure to Punch </a>
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
	<div class="row">
		<div class="d-grid col">
			<a class="btn btn-primary mb-2 btn-sm" href="{{url('ftp/create')}}" type="button">File FTP</a>
		</div>	
	
	</div>

	@foreach($list as $filerequest)
		<?php
			$date = Carbon::createFromFormat('Y-m-d',$filerequest->ftp_date);

		?>
		<div class = "card mystyle mb-2">
			<div class="card-header" > {{ $date->format('m/d/Y') }} </div>
			<div class="card-body mystyle" > 
				Type : {{ $filerequest->ftp_type }} <br>
				Time : {{ $filerequest->ftp_time }}  / {{ $filerequest->ftp_state }}<br>
				Reason : {{ $filerequest->ftp_remarks }}
			</div>
		</div>

	@endforeach
@endsection

<!-- ftp_date
ftp_state
ftp_time
ftp_type
ftr_remarks -->