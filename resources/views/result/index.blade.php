@extends('layouts.app')
@section('content')
    <div class="container">

                <div class="row">
                    @include('result.modals.addresult')
                     @include('result.modals.view')
                     @include('result.modals.bulk')
                     @include('result.modals.attendance')
                     @include('result.modals.vattendance')
                     @include('result.modals.editattendance')
                     @include('result.modals.rating')
                     @include('result.modals.erating')
                     @include('result.modals.vrating')
                     @include('result.modals.behaviour')
                     @include('result.modals.ebehaviour')
                     @include('result.modals.vbehaviour')
                     @include('result.modals.ca1')
                     @include('result.modals.ca2')
                     @include('result.modals.ca12')
                     @include('result.modals.exam')
                     @include('result.modals.editca')
                     @include('result.modals.editresult')
            <div class="col-lg-12">
            
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Results Manager</h3></div>
                <div class="panel-body">
            <div class="row pull-right">
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Results <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="addR">Import Results</a>
                      </li>
                    <li><a id="ca1">Add 1ST CA</a></li>
                    <li><a id="ca2">Add 2ND CA</a></li>
                    <li><a id="ca12">Add 1ST and 2ND CA</a></li>
                    <li><a id="exam">Add Exam</a></li>
                    <li><a id="editcabtn">Edit CA</a></li>
                    <li><a id="editresultbtn">Edit Results</a></li>
                    <li><a id="bulkR">Add Results</a></li>
                    <li><a id="classR">View Result</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Attendance <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="Abtn">Add Attendance</a></li>
                    <li><a id="EAbtn">Edit Attendance</a></li>
                    <li><a id="VAbtn">View Attendance</a></li>
                </ul>
            </div>
                        @if(session()->get('section') == "primary")
                        <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Behaviour <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="Bbtn">Add Behaviour</a></li>
                    <li><a id="EBbtn">Edit Behaviour</a></li>
                    <li><a id="VBbtn">View Behaviour</a></li>
                </ul>
            </div>
                        @elseif(session()->get('section') == "secondary")
                        <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Rating <span class="caret"></span></button>
                <ul class="dropdown-menu" role="menu">
                    <li><a id="Rbtn">Add Rating</a></li>
                    <li><a id="ERbtn">Edit Rating</a></li>
                    <li><a id="VRbtn">View Rating</a></li>
                </ul>
            </div>
                   
                        @endif
                    </div>
                    
                </div>
            </div>
                    </div>


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
             jQuery(document).ready( function () {
                 $("#addR").click(function () {
                     $("#addresult").modal('show');
                 })
				 $("#classR").click(function () {
                     $("#viewresult").modal('show');
                 })
				 $("#bulkR").click(function () {
                     $("#bulkresult").modal('show');
                 })
				 $("#ca1").click(function () {
                     $("#firstCa").modal('show');
                 })
				 $("#ca2").click(function () {
                     $("#secondCa").modal('show');
                 })
				 $("#ca12").click(function () {
                     $("#allCa").modal('show');
                 })
				 $("#exam").click(function () {
                     $("#Exam").modal('show');
                 })
				 $("#Abtn").click(function () {
                     $("#attendance").modal('show');
                 })
				 $("#VAbtn").click(function () {
                     $("#vattendance").modal('show');
                 })
				  $("#EAbtn").click(function () {
                     $("#editattendance").modal('show');
                 })
				 $("#Rbtn").click(function () {
                     $("#rating").modal('show');
                 })
				 $("#ERbtn").click(function () {
                     $("#erating").modal('show');
                 })
				 $("#VRbtn").click(function () {
                     $("#vrating").modal('show');
                 })
				 $("#Bbtn").click(function () {
                     $("#behaviour").modal('show');
                 })
				  $("#EBbtn").click(function () {
                     $("#ebehaviour").modal('show');
                 })
				  $("#VBbtn").click(function () {
                     $("#vbehaviour").modal('show');
                 })
				 $("#editcabtn").click(function () {
                     $("#editca").modal('show');
                 })
				 $("#editresultbtn").click(function () {
                     $("#editresult").modal('show');
                 })
				 
		$('#vlevel').on('change', function(e){
        console.log(e);
        var level = e.target.value;
 
        $.get('{{ url('subjectssecondary') }}/?level=' + level, function(data) {
            
            $('#vsubjects').empty();
			$('#vsubjects').append('<option></option>');
            $.each(data, function(index,subCatObj){
			 $('#vsubjects').append('<option value="' + subCatObj.id +'">' + subCatObj.title + '</option>');
            });
        });
    });
			
			
	$('#elevel').on('change', function(e){
        console.log(e);
        var level = e.target.value;
 
        $.get('{{ url('subjectssecondary') }}/?level=' + level, function(data) {
            
            $('#esubjects').empty();
			$('#esubjects').append('<option></option>');
            $.each(data, function(index,subCatObj){
			 $('#esubjects').append('<option value="' + subCatObj.id +'">' + subCatObj.title + '</option>');
            });
        });
    });			 
				 
			
	$('#ulevel').on('change', function(e){
        console.log(e);
        var level = e.target.value;
 
        $.get('{{ url('subjectssecondary') }}/?level=' + level, function(data) {
            
            $('#usubjects').empty();
			$('#usubjects').append('<option></option>');
            $.each(data, function(index,subCatObj){
			 $('#usubjects').append('<option value="' + subCatObj.id +'">' + subCatObj.title + '</option>');
            });
        });
    });					 
				 
				 
				 $("#saveR").click( function(e){
					 e.preventDefault();
					 var form = $("#Rform");
					 var formData = form.serialize();
					 var url = $("#find").attr("href");
					 console.log(formData);
					 $.ajax({
							type: 'post',
							url: url,
							data: formData,
							success: function(data){
								console.log(data);
								if(data == "exists"){
									var c = confirm('This Result Exists do you wish to update it?');
								if(c == true){
									form.submit();
								}
									}else if(data == "not"){
										form.submit();
										}
							},
							error: function(data) {
								console.log(data);
							}
						})
						
					 })

                 $('tbody').delegate("#sdelete", 'click', function (e) {
                     var c = confirm('Are You sure you want to delete Result');
                     if(!c == true){
                         e.preventDefault();
                     }
                 })
                 $("#byClass").change(function(e) {
                     console.log(this.value);
                     var level = this.value;
                     window.location.assign("{{url('result/byclass') }}/?class=" + level);
                 });

                 $("#bySubject").change(function(e) {
                     console.log(this.value);
                     var subject = this.value;
                     window.location.assign("{{url('result/bysubject') }}/?subject=" + subject);
                 });



             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop