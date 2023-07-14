@extends('errors::minimal')

<a href="{{ route('dashboard') }}"> Go back to Dashboard Page. </a>
@section('title', __('Not Found'))
@section('code', '404')
@section('message', __('Not Found'))
