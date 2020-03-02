@extends('layouts.gentelella-master.master')
  @section('title', 'Trưởng đơn vị')
  @section('css')
    <link rel="stylesheet" type="text/css" href="{{URL::asset('css/subadmin.css')}}">
  @endsection()

  @section('left-menu')
    @include('truongdonvi.layout.left-menu')
  @endsection()

  @section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/function.js') !!}"></script>
	@endsection()