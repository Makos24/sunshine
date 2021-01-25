@extends('layouts.app')
@section('content')
    <div class="container">

<h2 style="text-align:center">Edit Attendance</h2>
<form method="post" action="{{url('/updateattendance')}}" id="bform">
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
@foreach($res as $k => $r)
<tr>
    <td>{{++$k}}</td>
    <td width="150px"><input value="{{$r['id']}}" name="id[]" class="form-control" readonly></td>
    <td><input value="{{$r['name']}}" name="names[]" class="form-control" readonly></td>
    <td width="150px"><input type="number" value="{{$r['present']}}" name="present[]" class="form-control" required></td>
    <td width="150px"><input type="number" name="late[]" value="{{$r['late']}}" class="form-control" required></td>
</tr>
@endforeach
    </tbody>
</table>
<div class="col-lg-6">
            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                <label for="total" class="control-label">Total Attendance</label>
                <input type="number" value="{{$r['total']}}" class="form-control" name="total" required>
                @if ($errors->has('total'))
                    <span class="help-block">
<strong>{{ $errors->first('total') }}</strong>
</span>
                @endif
            </div>
        </div>

<input type="hidden" value="{{$data['class_id']}}" name="class">
<input type="hidden" value="{{$data['div']}}" name="div">
<input type="hidden" value="{{$data['term_id']}}" name="term">
<input type="hidden" value="{{$data['session']}}" name="session">                 
               
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveAtt">Update Attendance</button>
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