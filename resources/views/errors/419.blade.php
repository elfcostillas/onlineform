@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')

<a href="{{ route('login') }}"> Go back to login page. </a>
@section('message', __('Page Expired'))
