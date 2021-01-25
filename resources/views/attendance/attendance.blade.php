@extends('layouts.app')
@section('content')
    <div class="container">

<h2 style="text-align:center">{{$class}} Attendance Sheet</h2>
<form method="post" action="{{url('/inputattendance')}}" id="bform">
<a id="fina" href="{{url('/checkattendance')}}"></a>
 {{csrf_field()}}
<table class="table table-responsive">

    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>No. of times Present</th>
        <th>No. of times Late</th>       
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
    <tr>
        <td>{{++$k}}</td>
        <td width="150px"><input value="{{$student->student_id}}" name="id[]" class="form-control" readonly></td>
        <td><input value="{{$student->getName()}}" name="names[]" class="form-control" readonly></td>
        <td width="150px"><input type="number" name="present[]" class="form-control" required></td>
        <td width="150px"><input type="number" name="late[]" class="form-control" required></td>
    </tr>
    @endforeach
    </tbody>
</table>
<div class="row">
<input type="hidden" value="{{$student->level}}" name="class">
<input type="hidden" value="{{$student->class}}" name="div">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option value=""></option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                            </select>
                            @if ($errors->has('term'))
                                <span class="help-block">
        <strong>{{ $errors->first('term') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="control-label">Session</label>
                            <select name="session" class="form-control" required>
                                <option value=""></option>
                                @for($i = 2015; $i<= date('Y'); $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @if ($errors->has('session'))
                                <span class="help-block">
        <strong>{{ $errors->first('session') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>

                </div>
               
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="total" class="control-label">Total Attendance</label>
                           	<input type="number" class="form-control" name="total" required>
                            @if ($errors->has('total'))
                                <span class="help-block">
        <strong>{{ $errors->first('total') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    
                </div>
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveAtt">Save Attendance</button>
</div>
</form>
</div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
              
//				 $("#saveAtt").click( function(e){
//					 e.preventDefault();
//					 var form = $("#bform");
//					 var formData = form.serialize();
//					 var url = $("#fina").attr("href");
//					 console.log(formData);
//					 $.ajax({
//							type: 'post',
//							url: url,
//							data: formData,
//							success: function(data){
//								console.log(data);
//								if(data == "exists"){
//									var c = confirm('This Attendance Exists do you wish to update it?');
//								if(c == true){
//									form.submit();
//								}
//									}else if(data == "not"){
//										form.submit();
//										}
//							},
//							error: function(data) {
//								console.log(data);
//							}
//						})
//
//					 })
//
             })
</script>   
    @stop
     
@stop