@extends('layouts.gentelella-master.master')
  @section('title', 'Student')
      
  @section('left-menu')
    @include('sinhvien.layout.left-menu')
  @endsection()

  @section('javascript')
    @parent
    <script type="text/javascript" src="{!! URL::asset('js/alert.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/ajax.js') !!}"></script>
    <script type="text/javascript" src="{!! URL::asset('js/function.js') !!}"></script>
  @endsection()