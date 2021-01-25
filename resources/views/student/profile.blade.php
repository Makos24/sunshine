@extends('layouts.app')
@section('content')
    <div class="container">

<div class="row">
    <div class="col-lg-12 center-block">
        <div id="{{$levels = $results->groupBy('class')}}">

            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    Export <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a target="_blank" href="{{url("/transcriptpdf/".$student->id)}}">To PDF</a></li>
                    <li><a target="_blank" href="{{url("/transcriptexcel/".$student->id)}}" >To Excel</a></li>
                </ul>
            </div>
            <a target="_blank" href="{{url("/transcript/".$student->id)}}" class="btn btn-primary">Print</a>
        @include('student.block')
        @foreach($levels as $k => $level)
            @include('student.show')
        @endforeach
        <!-- /. ROW  -->
            <!-- /. ROW  -->
        </div>
        <!-- /. PAGE INNER  -->
    </div>
<!-- /. PAGE WRAPPER  -->
</div>
            </div>
    <!-- /. WRAPPER  -->
@stop