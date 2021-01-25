@extends('layouts.app')
@section('content')
    <div class="container">

                <div class="row">
                    <div class="col-lg-10">
                        <h1></h1>
                        <h2>{{''}} Email List</h2>
                        <form method="post" action="{{url('/students/emails')}}" >
                            {{csrf_field()}}
                            <table class="table table-bordered">

                                <thead>
                                <tr>
                                    <th>S/No</th>
                                    <th>Student Reg. Number</th>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Alternative Email</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($students as $k => $student)
                                    <tr>
                                        <td>{{++$k}}</td>
                                        <td width="150px"><input type="hidden" value="{{$student->student_id}}" name="id[]" >
                                            {{$student->student_id}}
                                        </td>
                                        <td><input type="hidden" value="{{$student->getName()}}" name="names[]" >
                                            {{$student->getName()}}
                                        </td>
                                        <td><input type="email" name="email[{{$student->student_id}}]"
                                                  value="{{$student->email}}" class="form-control" required></td>
                                        <td><input type="email" value="{{$student->alt_email}}"
                                                   name="alt_email[{{$student->student_id}}]" class="form-control" ></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary pull-right" id="saveB">Save Emails</button>
                            </div>
                        </form>
                    </div>
                </div>
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