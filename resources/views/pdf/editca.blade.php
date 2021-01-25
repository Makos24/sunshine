@extends('layouts.app')
@section('content')
    <div class="container">

                <h2>{{\Portal\Models\Setting::where('key','title')->first()->value}}</h2>
<h3>{{$data['subject'].' 1ST AND 2ND CA FOR '.$data['class'].' '.$data['session'].' SESSION'}}</h3>
<form method="post" action="{{url('/results/posteditca')}}" id="bulkform">
<a id="finb" href="{{url('/results/check')}}"></a>
 {{csrf_field()}}
<table class="table table-responsive">

    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>CA 1</th>
        <th>CA 2</th>
        
        
        
    </tr>
</thead>
<tbody>
@foreach($res as $k => $r)
<tr>
  <td>{{++$k}}</td>
  <td width="150px"><input value="{{$r['id']}}" name="id[]" class="form-control" readonly></td>
  <td><input value="{{$r['name']}}" name="names[]" class="form-control" readonly></td>
  <td width="80px"><input type="text" value="{{$r['ca1']}}" name="ca1[]" class="form-control" required></td>
  <td width="80px"><input type="text" value="{{$r['ca2']}}" name="ca2[]" class="form-control" required ></td>
</tr>
@endforeach
</tbody>
</table>
<div class="row">
<input type="hidden" value="{{$data['class_id']}}" name="class">
<input type="hidden" value="{{$data['div']}}" name="div">
<input type="hidden" value="{{$data['term_id']}}" name="term">
<input type="hidden" value="{{$data['session']}}" name="session">
<input type="hidden" value="{{$data['sub_id']}}" name="subject">
                    
                  

                </div>
                
                
<div class="form-group">
     <button type="submit" class="btn btn-primary pull-right" id="saveB">Update Results</button>
</div>
</form>
</div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
               
//				 $("#saveB").click( function(e){
//					 e.preventDefault();
//					 var form = $("#bulkform");
//					 var formData = form.serialize();
//					 var url = $("#finb").attr("href");
//					 $.ajax({
//							type: 'post',
//							url: url,
//							data: formData,
//							success: function(data){
//								console.log(data);
//								if(data == "exists"){
//									var c = confirm('This Result Exists do you wish to update it?');
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
					//console.log(ca1);
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop