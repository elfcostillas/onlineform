<?php
	use Carbon\Carbon;

	function carbonDate($date){
        return Carbon::createFromFormat('Y-m-d',$date);
        //$docdate = Carbon::createFromFormat('Y-m-d H:i:s.u',$row->DocDate);
    }
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
					title: 'Confirm and Approve Leave',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Approve'
				}).then((result) => {
					if (result.value) {                       
						$.post('leave-approval/approve',{ id : this.id },function(data){
							window.location.reload();
						});
					}
				});
			});

			$(".denyBtn").on('click',function(){
				Swal.fire({
					title: 'Deny Leave',
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
						$.post('leave-approval/deny',{ id : this.id, remarks : result.value },function(data){
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

@include('app.nav-header')

@section('page-content')
	@if($msg=='')
		@if($list->count()==0)
			<div class = "card">
			<div class="card-header" > &nbsp;    </div>
				<div class="card-body mystyle" > 
					No pending leave request.
				</div>
			</div>
				
			@endif

			@foreach($list as $filerequest)
				<?php
					
					
				?>
				<div class = "card mystyle mb-2">			
					<div class="card-header" >  {{ $filerequest->employee_name }}  </div>
					<div class="card-body mystyle" > 
					
					<b>Date Inclusive : </b> {{ carbonDate($filerequest->date_from)->format('m/d/Y') }} - {{ carbonDate($filerequest->date_to)->format('m/d/Y') }} <br>
					<b>Leave Type : </b> {{ $filerequest->leave_type }} <br>
					<b>Reason : </b> {{ $filerequest->remarks }}  <br>
					<b> With Pay : </b> {{ round($filerequest->with_pay/8,2) }} <br>
                	<b> Without Pay : </b> {{ round($filerequest->without_pay/8,2) }} <br>
                
					</div> 
		
					<button id="{{$filerequest->id}}" type="button" class="btn btn-success mb-2 apprvBtn" >Approve</button>
					<button id="{{$filerequest->id}}" type="button" class="btn btn-danger denyBtn">Deny</button>

				</div>

			@endforeach
		@else
			<div class = "card">
				<div class="card-header" > Error    </div>
					<div class="card-body mystyle" > 
						{{$msg}}
					</div>
				</div>
			</div>

		@endif
		@endsection
	
