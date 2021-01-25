@extends('layouts.app')
@section('content')
    <div class="container">

@if(isset($res))
<div class="row">
    <div class="col-lg-11" >
        <div class="panel-heading">
            <div>
            <form class="form-inline">
            <div class="row">

                <label class="control-label">View By Class</label>
                <select class="form-control" id="byClass">
                	<option value=""></option>
                        @if(session()->get('section') == "primary")
                        <option value="4">Primary 1</option>
                        <option value="5">Primary 2</option>
                        <option value="6">Primary 3</option>
                        <option value="7">Primary 4</option>
                        <option value="8">Primary 5</option>
                        <option value="9">Primary 6</option>
                        @elseif(session()->get('section') == "secondary")
                        <option value="10">JSS 1</option>
                        <option value="11">JSS 2</option>
                        <option value="12">JSS 3</option>
                        <option value="13">SS 1</option>
                        <option value="14">SS 2</option>
                        <option value="15">SS 3</option>
                        @endif
                </select>

                <label class="control-label">View By Subject</label>
            	<select class="form-control" id="bySubject">
                	<option value=""></option>
                        @foreach($subjects as $subject)
                            <option value="{{$subject->id}}">
                            @if($subject->title == 'MATHEMATICS' || $subject->title == 'mathematics')
                            	@if($subject->sub_section == 1)
                            		{{$subject->title.' junior'}}
                                @elseif($subject->sub_section == 2)
                            		{{$subject->title.' senior'}}
                                 @endif

                            @else
                            {{$subject->title}}
                            @endif
                            </option>
                        @endforeach
                </select>

            </div>
            </form></div>
            </div>
    <div class="table-responsive center-block">
    <table class="table table-bordered">
        <thead style="font-weight: bold">
        <td>S/No.</td>
        <td>Subject</td>
        <td>Term</td>
        <td>Session</td>
        <td>Class</td>
        <td>Actions</td>
        </thead>
        <tbody>
        @foreach($res as $k => $results)
            <tr>
                <td>{{++$k}}</td>
                <td>{{$results['subject']}}</td>
                <td>{{$results['term']}}</td>
                <td>{{$results['session']}}</td>
                <td>{{$results['class']}}</td>
                <td>
                    <div class="action">
                        <a href="{{url("/results/view/".$results['sub_id']."/".$results['class_id']."/".$results['div']."/".$results['session']."/".$results['term_id'])}}" id="sview" class="fa fa-file-text-o fa-2x" title="View Result" ></a>
                        <a href="{{url("/editresult/".$results['sub_id']."/".$results['class_id']."/".$results['div']."/".$results['session']."/".$results['term_id'])}}" name="" id="edit" class="fa fa-edit fa-2x" title="Edit subject Data"></a>
                        <a href="{{url("/removesc/".$results['sub_id']."/".$results['class_id']."/".$results['div']."/".$results['session']."/".$results['term_id'])}}" id="sdelete" class="fa fa-trash-o fa-2x" title="Delete Result" ></a>

                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    <div class="pager">{!! $res->render() !!}</div>
        </div>
    </div>

        @endif
                        <!-- /. PAGE INNER  -->
                </div>
            </div>
@section('footer')
     <script type="text/javascript">
         jQuery(document).ready(function () {

		$('tbody').delegate("#sdelete", 'click', function (e) {
                 var c = confirm('Are You sure you want to delete Result');
                 if(!c == true){
                     e.preventDefault();
                 }
             })
		$("#byClass").change(function(e) {
            console.log(this.value);
			var level = this.value;
			window.location.assign("{{url('results/byclass') }}/?class=" + level);
        });

		$("#bySubject").change(function(e) {
            console.log(this.value);
			var subject = this.value;
			window.location.assign("{{url('results/bysubject') }}/?subject=" + subject);
        });


         });
     </script>

@stop
    <!-- /. WRAPPER  -->
@stop
