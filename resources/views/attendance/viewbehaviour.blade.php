@extends('layouts.app')
@section('content')
    <div class="container">

<h2 style="text-align:center">{{$data['class']}} BEHAVIOUR/APPEARANCE FOR {{$data['term']}} TERM {{$data['session']}}</h2>
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
        <td width="150px">{{$behave['student_id']}}</td>
        <td width="250px">{{$behave['name']}}</td>
        <td>{{$behave['app']}}</td>
        <td>{{$behave['be']}}</td>
    </tr>
    @endforeach
    </tbody>
</table>    
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