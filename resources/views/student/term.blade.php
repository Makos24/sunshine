@extends('layouts.app')
@section('content')

@include('result.modals.editresultform')

        <div class="container">
            <div class="row">
                <div class="col-lg-11" id="{{$levels = $results->where('term',$term)->groupBy('class')}}">
                    <a class="btn btn-info" target="_blank" href="{{url("/resulttpdf/".$student->id."/".$level."/".$term."/".$session)}}">To PDF</a></li>

                    {{--<div class="btn-group">--}}
                    {{--<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">--}}
                    {{--Export <span class="caret"></span></button>--}}
                    {{--<ul class="dropdown-menu" role="menu">--}}
                    {{--<li>--}}{{--<li><a target="_blank" href="{{url("/resulttexcel/".$student->id."/".$level."/".$term."/".$session)}}" >To Excel</a></li>--}}
                    {{--</ul>--}}
                    {{--</div>--}}
                    <a target="_blank" href="{{url("/termprint/".$student->id."/".$level."/".$term."/".$session)}}" class="btn btn-primary">Print</a>
                    <a name="{{url("/termedit/".$student->id."/".$level."/".$term)}}" class="btn btn-primary" id="editTermResult" >Edit</a>
                    @include('student.block')
                    @foreach($levels as $k => $level)
                        @include('student.show')
                    @endforeach
                </div>
            </div>
        <!-- /. PAGE INNER  -->
    </div>
@stop
    <!-- /. WRAPPER  -->
     @section('footer')
         <script type="text/javascript">
		 	jQuery(document).ready(function(e) {
                $("#editTermResult").click(function () {
			$("#formdiv").empty();
			$.get(this.name, function(data){
				$.each(data, function(index, result){
					$("#formdiv").append('<tr><td>'+result.subject+'</td><td><input class="form-control" size="7" type="text" value="'+result.ca1+'" name="ca1[]" /></td><td><input class="form-control" size="7" type="text" value="'+result.ca2+'" name="ca2[]" /></td><td><input class="form-control" type="text" size="6" value="'+result.exam+'" name="exam[]"/></td><input type="hidden" value="'+result.subject_id+'" name="subject[]" /><input type="hidden" value="'+result.class+'" name="class[]" /><input type="hidden" value="'+result.term+'" name="term[]" /><input type="hidden" value="'+result.student_id+'" name="student_id[]" /></tr>');
					});
				});

                     $("#editResultForm").modal('show');

                 })
            });
		 </script>


@stop
