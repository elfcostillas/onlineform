@extends('app.layout')

@section('csslib')

		
@endsection

@section('jslib')      

		<script>
			$(document).ready(function(){
				$("#ftp_date").datepicker();

				$("#ftp_state").on('change',function(e){
					let val = $(this).find(":selected").val();
					
					$.get(`scheds/${val}`,function(data){
						let str = '';
						for(x =0; x < data.length;x++)
						{
						
							str += "<option value=" +data[x]['time_in'] +"> "+ data[x]['hrs'] +":"+data[x]['mins']+" "+ data[x]['ampm'] +" </option>";
						}

						$("#ftp_time").html(str);
					});
				});
			});
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
	<div class="row">
		<div class="d-grid col">
			<a class="btn btn-primary mb-2 btn-sm" href="{{url('ftp')}}" type="button">Back to List</a>
		</div>	
	
	</div>

	@if($errors->any())
	<div class="alert alert-danger alert-sm" role="alert">
	{{ $errors->first() }}
	</div>
	@endif
	<div class="card mystyle">
		<div class="card-header"> FTP Form</div>
		<div class="card-body">
			<form class="row" method="POST" action="create">
				@csrf
				<div class="col-4"> <label class="mb-2" for="">Date</label> 
					<input type="text" class="form-control form-control-sm" required name="ftp_date" id="ftp_date" autocomplete="off" value="{{ old('ftp_date')}}">
				</div>
				<div class="col-4"> <label class="mb-2" for="">Punch Type</label> 
					<select class="form-select form-select-sm" name="ftp_state" id="ftp_state"  value="{{ old('ftp_state')}}">
						<option value="In"> Clock In</option>
						<option value="Out"> Clock Out</option>
						<option value="InOT"> Clock In (OT)</option>
						<option value="OutOT"> Clock Out (OT)</option>
					</select>
				</div>
				<div class="col-4"> <label class="mb-2" for="">Time</label> 
					<select class="form-select form-select-sm" name="ftp_time" id="ftp_time"  value="{{ old('ftp_time')}}">
						@foreach($schedules as $sched)
							<option value="{{ $sched->time_in }}"> {{ $sched->hrs }}:{{ $sched->mins }}  {{ $sched->ampm }} </option>
						@endforeach
					</select>
				</div>
				
				<div class="col-4 mt-3">
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="ftp_type" id="inlineRadio1"  required value="OB">
						<label class="form-check-label" for="inlineRadio1">Official Business</label>
					</div>
				</div>
				<div class="col-4 mt-3">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="ftp_type" id="inlineRadio2" required value="PR">
							<label class="form-check-label" for="inlineRadio2">Personal</label>
						</div>
				</div>	
				<div class="col-12  mt-2">
					<textarea class="form-control form-control-sm" name="ftp_remarks" id="ftp_remarks" value="{{ old('ftp_remarks')}}" required rows="3"></textarea>
				</div>
				<div class="d-grid col mt-3">
					<button class="btn btn-success btn-sm" type="submit"> Submit</button>
				</div>
			</form>
		</div>
	</div>

	







@endsection



<!-- ftp_date
ftp_state
ftp_time
ftp_type
ftr_remarks -->