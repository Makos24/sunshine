@extends('layouts.app')
@section('content')
    <div class="container">

               
<h3 style="text-align:center">EDIT {{$data['class']}} BEHAVIOUR/APPEARANCE FOR {{$data['term']}} TERM {{$data['session']}}</h3>
<form method="post" action="{{url('/updatebehaviour')}}" id="bform">
<a id="fina" href="{{url('/checkattendance')}}"></a>
 {{csrf_field()}}
<table class="table table-responsive">

    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Appearance</th>
        <th>Behaviour</th>       
    </tr>
    </thead>
    <tbody>
    @foreach($behaviours as $k => $behave)
    <tr>
        <td>{{++$k}}</td>
        <td width="150px"><input value="{{$behave['student_id']}}" name="id[]" class="form-control" readonly></td>
        <td width="250px"><input value="{{$behave['name']}}" name="name[]" class="form-control" readonly></td>
        <td>
 		<select name="appearance[]" class="form-control" required>
        <option value="{{$behave['appearance']}}">{{$behave['app']}}</option>
        <option value="1">SMART</option>
        <option value="2">NEAT</option>
        <option value="3">GOOD</option>
        <option value="4">DIRTY</option>
        <option value="5">ROUGH</option>
        </select>	       
        </td>
        <td>
        <select name="behaviour[]" class="form-control" required>
        <option value="{{$behave['behaviour']}}">{{$behave['be']}}</option>
        <option value="1">WELL BEHAVED</option>
        <option value="2">GOOD CONDUCT</option>
        <option value="3">GOOD</option>
        <option value="4">SATISFACTORY</option>
        <option value="5">NAUGHTY</option>
        </select>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
<input type="hidden" value="{{$data['class_id']}}" name="class">
<input type="hidden" value="{{$data['div']}}" name="div">
<input type="hidden" value="{{$data['term_id']}}" name="term">
<input type="hidden" value="{{$data['session']}}" name="session">   
               
               
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveBhv">Update Behaviour/Appearance</button>
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