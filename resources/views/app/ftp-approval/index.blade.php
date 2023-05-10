<?php
	use Carbon\Carbon;
?>

@extends('app.layout')

@section('csslib')

		<!-- <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"> -->
@endsection

@section('jslib')      
	<script>
		$(document).ready(function(){

			$(".apprvBtn").on('click',function(){
				Swal.fire({
					title: 'Confirm and Approve FTP',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Approve'
				}).then((result) => {
					if (result.value) {                       
						$.post('ftp_approval/approve',{ id : this.id },function(data){
							window.location.reload();
						});
					}
				});
			});

			$(".denyBtn").on('click',function(){
				Swal.fire({
					title: 'Deny FTP',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					input : 'text',
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Deny'
				}).then((result) => {
					console.log(result);
					if (result.value) {                       
						$.post('ftp_approval/deny',{ id : this.id, remarks : result.value },function(data){
							window.location.reload();
						});
					}
				});
			});
			
		});

		// function post(path,id){
		// 	const form = document.createElement('form');
		// 	form.method = 'POST';
		// 	form.action = path;

		// 	const hiddenField = document.createElement('input');
		// 	hiddenField.type = 'hidden';
		// 	hiddenField.name = 'id';
		// 	hiddenField.value = id;

		// 	form.appendChild(hiddenField);

		// 	document.body.appendChild(form);

		// 	form.submit();
		// }
	</script>
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

	@if($list->count()==0)
	<div class = "card">
	<div class="card-header" > &nbsp;    </div>
		<div class="card-body mystyle" > 
			No pending FTP.
		</div>
	</div>
		
	@endif

	@foreach($list as $filerequest)
		<?php
			$date = Carbon::createFromFormat('Y-m-d',$filerequest->ftp_date);
			
		?>
		<div class = "card mystyle mb-2">
			<div class="card-header" >  {{ $filerequest->employee_name }}  </div>
			<div class="card-body mystyle" > 
				Date : {{ $date->format('m/d/Y') }} <br>
				Type : {{ $filerequest->ftp_type }} <br>
				Time : {{ $filerequest->ftp_time }}  / {{ $filerequest->ftp_state }}<br>
				Reason : {{ $filerequest->ftp_remarks }}
				
			</div>
			<button id="{{$filerequest->id}}" type="button" class="btn btn-success mb-2 apprvBtn" >Approve</button>
			<button id="{{$filerequest->id}}" type="button" class="btn btn-danger denyBtn">Deny</button>
			<!-- <button type="button" class="btn btn-success mb-2" onclick="confirmApprove({{$filerequest->id}})">Approve</button>
			<button type="button" class="btn btn-danger" onclick="confirmDeny({{$filerequest->id}})">Deny</button> -->
			<!-- <div class="row">
				<div class="col-6">
					<button type="button" class="btn btn-success">Approve</button>
				</div>
				<div class="col-6">
					<button type="button" class="btn btn-danger">Deny</button>
				</div>
			<div> -->
		</div>

	@endforeach
@endsection



<!-- ftp_date
ftp_state
ftp_time
ftp_type
ftr_remarks -->