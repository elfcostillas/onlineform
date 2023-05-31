@extends('app.layout')

@section('csslib')

		
@endsection

@section('jslib')      

		<script>
			$(document).ready(function(){
				$("#date_to").datepicker();
				$("#date_from").datepicker();
				// $("#ftp_state").on('change',function(e){
				// 	let val = $(this).find(":selected").val();
					
				// 	$.get(`scheds/${val}`,function(data){
				// 		let str = '';
				// 		for(x =0; x < data.length;x++)
				// 		{
						
				// 			str += "<option value=" +data[x]['time_in'] +"> "+ data[x]['hrs'] +":"+data[x]['mins']+" "+ data[x]['ampm'] +" </option>";
				// 		}

				// 		$("#ftp_time").html(str);
				// 	});
				// });
			});
		</script>
@endsection

@include('app.nav-header')

@section('page-content')

	<div class="row">
		<div class="d-grid col">
			<a class="btn btn-primary mb-2 btn-sm" href="{{url('leave-request')}}" type="button">Back to List</a>
		</div>	
	
	</div>
	@if($errors->any())
	<div class="alert alert-danger alert-sm" role="alert">
	{{ $errors->first() }}
	</div>
	@endif
	@if($consumed) 
	<div class="card mystyle mb-2">
		<div class="card-header"> Remaining Leave Balance</div>
			<div class="card-body">
				<div class="row">
					<div class="col-6"><b>VL :</b> {{ ($consumed[0]->vacation_leave - $consumed[0]->VL_PAY)}} </div>
					<div class="col-6"><b>SL :</b> {{ ($consumed[0]->sick_leave - $consumed[0]->SL_PAY)}} </div>
				</div>
			</div>		
	</div>	
	@endif
	<div class="card mystyle">
		<div class="card-header"> Leave Form</div>
		<div class="card-body">
			<form class="row" method="POST" action="edit">
				@csrf
				
					<div class="col-6"> <label class="mb-2" for="">Date From</label> 
						<input type="text" class="form-control form-control-sm" required name="date_from" id="date_from" autocomplete="off" value="{{ old('date_from')}}">
					</div>
					<div class="col-6"> <label class="mb-2" for="">Date To</label> 
						<input type="text" class="form-control form-control-sm" required name="date_to" id="date_to" autocomplete="off" value="{{ old('date_to')}}">
					</div>
				
				
					<div class="col-6"> <label class="mb-2" for="">Reliever</label> 
						<select class="form-control form-control-sm" name="emp_reliever" id="emp_reliever">
							<option value="">Select Reliever</option>
							@foreach($reliever as $r)
								<option value="{{ $r->biometric_id }}"> {{ $r->emp_name }} </option>
							@endforeach
						</select>
					</div>
					<div class="col-6"> <label class="mb-2" for="">Leave Type</label> 
						<select class="form-control form-control-sm" name="leave_type" id="leave_type">
							@foreach($types as $t)
								<option value="{{ $t->leave_type_code }}"> {{ $t->leave_type_desc }} </option>
							@endforeach
						</select>
					</div>
				
				
					<div class="col-12"> <label class="mb-2" for="">Reason</label> 
						<textarea class="form-control form-control-sm" name="reason" id="reason" cols="30" rows="3"></textarea>
					</div> 
				
					<div class="d-grid col mt-2">
						<button class="btn btn-success btn-sm" type="submit"> Proceed</button>
					</div>
				</div>
				
			</form>
		</div>
	</div>

@endsection
