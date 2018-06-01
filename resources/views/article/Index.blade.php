@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('css/article.css')}}">
@endsection

@section('content')
	<articlelist></articlelist>
@endsection