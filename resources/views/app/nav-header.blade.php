<?php

$prefix = Request::route()->getPrefix();
?>

@section('navbar')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JLR </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
	    <!-- <a class="nav-link {{ ($prefix == '/ftp') ? 'active' : '' }}" aria-current="page" href="{{ url('ftp') }}">FTP</a>
        <a class="nav-link {{ ($prefix == '/ftp_approval') ? 'active' : '' }}" aria-current="page" href="{{ url('ftp_approval') }}">FTP Approval</a> -->
        <a class="nav-link {{ ($prefix == '/leave-request') ? 'active' : '' }}" href="{{ url('leave-request') }}">Leave Request</a>
        <a class="nav-link {{ ($prefix == '/leave-approval') ? 'active' : '' }}" href="{{ url('leave-approval') }}">Leave Approval</a>
        <a class="nav-link {{ ($prefix == '/attendance') ? 'active' : '' }}" href="{{ url('attendance') }}">Attendance</a>
		<a class="nav-link" href="#" onclick="fnLogOut()" >Logout</a>
      </div>
    </div>
  </div>
</nav>
@endsection