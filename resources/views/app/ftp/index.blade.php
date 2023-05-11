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

@include('app.nav-header')

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
				Reason : {{ $filerequest->ftp_remarks }}<br>
				Status : {{ $filerequest->ftp_status }}<br>
				Remarks : {{ $filerequest->remarks }}
			</div>
		</div>

	@endforeach
	<div>
	<nav aria-label="Page navigation example">
		<ul class="pagination">
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Previous">
					<span aria-hidden="true">&laquo;</span>
					<span class="sr-only">Previous</span>
				</a>
			</li>
			<li class="page-item"><a class="page-link" href="#">1</a></li>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
			<li class="page-item"><a class="page-link" href="#">3</a></li>
			<li class="page-item"><a class="page-link" href="#">4</a></li>
			<li class="page-item"><a class="page-link" href="#">5</a></li>
			<li class="page-item"><a class="page-link" href="#">6</a></li>
			<li class="page-item">
				<a class="page-link" href="#" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
					<span class="sr-only">Next</span>
				</a>
			</li>
		</ul>
	</nav>
	</div>
@endsection

<!-- ftp_date
ftp_state
ftp_time
ftp_type
ftr_remarks -->