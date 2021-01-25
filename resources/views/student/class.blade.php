@extends('layouts.app')
@section('content')
    <div class="container">

<div class="row">
<div class="col-lg-12 center-block">
    <div id="{{$levels=$results->groupBy('class')}}">
        <div class="btn-group">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                Export <span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">
                <li><a target="_blank" href="{{url("/resultpdf/".$results[0]->class."/".$student->id."/".$results[0]->session)}}">To PDF</a></li>
                {{--<li><a target="_blank" href="{{url("/resultexcel/".$r[1][0]->class."/".$student->id."/".$session)}}" >To Excel</a></li>--}}
            </ul>
        </div>
        <a target="_blank" href="{{url("/classprint/".$results->first()->class."/".$student->id."/".$results->first()->session)}}" class="btn btn-primary">Print</a>
        @include('student.block')
        {{--<h4 style="margin-left: 320px">{{$student->student_class}} RESULTS</h4>--}}
        @foreach($levels as $k => $level)
            @include('student.show')
        @endforeach


    </div>
</div>
<!-- /. PAGE INNER  -->
</div>
</div>

@stop