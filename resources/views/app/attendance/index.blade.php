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
			$('#btnView').on('click',function(e){	
				e.preventDefault();

				let year = $("#ddYEar").val();
				let month = $("#ddMonth").val();
				let period = $("#ddPeriod").val();

				if(period != ''){
					let url = `attendance/get-dtr/${period}`;
					
					$.get(url,function(data){
						let str = '';
						var thead = '<thead><tr>'
										+'<td>Day</td>'
										+'<td>Date</td>'
										+'<td>Time In</td>'
										+'<td>Time Out</td>'
										+'<td>OT In</td>'
										+'<td>OT Out</td>'
									+'</tr></thead>';

						for(x =0; x < data.length;x++)
						{
						
							var time_in = (data[x]['time_in']==null) ? '' : data[x]['time_in'];
							var time_out = (data[x]['time_out']==null) ? '' : data[x]['time_out'];
							var ot_in = (data[x]['ot_in']==null) ? '' : data[x]['ot_in'];
							var ot_out = (data[x]['ot_out']==null) ? '' : data[x]['ot_out'];

							str += '<tr>'
									+'<td> ' + data[x]['wd'] + ' </td> '
									+'<td> ' + data[x]['fdate'] + ' </td> '
									+'<td>'+ time_in +'</td>'
									+'<td>'+ time_out +'</td>'
									+'<td>'+ ot_in +'</td>'
									+'<td>'+ ot_out +'</td>'
							 	+'</tr>';
						}
						
						var tbody = '<tbody>'+ str +'</tbody>';	
						var table = thead + tbody;
						console.log(thead,tbody,table);
						$("#dtrtable").html(table);
					});

				
				}

			});

			$('.ddchange').on('change',function(e){
				e.preventDefault();

				let year = $("#ddYEar").val();
				let month = $("#ddMonth").val();

				let url = `attendance/get-periods/${year}/${month}`;

				$.get(url,function(data){
					let str = '';
					
					for(x =0; x < data.length;x++)
					{
						str += "<option value=" +data[x]['id'] +"> "+ data[x]['label'] +" </option>";
					}

					$("#ddPeriod").html(str);
				});
			});

			
			
		});
	</script>
	<style>
		* {
			font-size : 10pt;
		}
	</style>
@endsection

@include('app.nav-header')

@section('page-content')
	<div class="container">
		<form>
			<div class="row">
				<div class="col-4">
					<select class="form-control ddchange" name="ddYEar" id="ddYEar">
						@foreach($years as $year)
							<option value="{{ $year->yr }}">{{ $year->yr }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-4">
					<select class="form-control ddchange" name="ddMonth" id="ddMonth">
							<option value="">Select Month</option>
						@foreach($months as $m => $value)
							<option value="{{ $m }}">{{ $value }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-4">
					<select class="form-control" name="" id="ddPeriod">
						@foreach($months as $m => $value)
							<option value=""></option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-12">
					<button id="btnView" class="form-control btn btn-primary" > View </button>
				</div>
				<div class="col-12">
					<table id="dtrtable" class="table table-striped">

					</table>
				</div>
			</div>
		</form>
	</div>

@endsection



<!-- ftp_date
ftp_state
ftp_time
ftp_type
ftr_remarks -->