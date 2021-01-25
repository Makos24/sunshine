@extends('layouts.app')
@section('content')
    <div class="container">

                    @include('subject.modals.newsubject')
                    @include('subject.modals.editsubject')
@if(isset($subjects))
<div class="row">
    <div class="col-lg-11" >
        <div class="panel-heading">
            <div class="">
                <button type="button" class="btn btn-info" id="addSub">Add Subject</button>
                <!--<button type="button" class="btn btn-info" id="up">Import Subjects</button>
                <button type="button" class="btn btn-info" id="export">Export</button>
                <button type="button" class="btn btn-info" id="print">Print</button>-->
            </div>
            </div>
    <div class="table-responsive center-block">
    <table class="table table-bordered">
        <thead>
        <td>S/No.</td>
        <td>Subject Name</td>
        <td>School Section</td>
        <td>Sub Section</td>
        <td>Actions</td>
        </thead>
        <tbody>
        @foreach($subjects as $k => $subject)
            <tr>
                <td>{{++$k}}</td>
                <td>{{$subject->title}}</td>
                <td>{{$subject->section}}</td>
                <td>
                @if($subject->sub_section == 1)
                {{'Junior'}}
                @elseif($subject->sub_section == 2)
                {{'Senior'}}
                @else
                {{' '}}
                @endif
                </td>
                <td>
                    <div class="action">
                        <a href="#" name="{{$subject->id}}" id="edit" class="fa fa-edit fa-2x" title="Edit subject Data">
                        </a><a href="{{url("/subject/delete/".$subject->id)}}" id="sdelete" class="fa fa-trash-o fa-2x" title="Delete subject" ></a>
                       </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
        </div>
    </div>
</div>

        @endif
                        <!-- /. PAGE INNER  -->
                </div>
@section('footer')
     <script type="text/javascript">
         jQuery(document).ready(function () {
             $("#addSub").click( function () {
                 $("#addSubject").modal('show');
             });
             $('tbody').delegate("#edit", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getSubject(val);
                 $("#editSubject").modal('show');
             })
             function getSubject(id) {
                 $.post({
                     type: 'post',
                     url : '{{url("/subjectJSON")}}',
                     data : {id: id},
                     success : function (data) {
						  //console.log(data);
                         $("#stitle").val(data.title);
                         $("#subject_id").val(data.id);
                         $("#section").val(data.section);
						 $("#sub_section").val(data.sub_section);
                     },
                     error : function (data) {
                         console.log(data);
                     },
                 });
             }

             $('tbody').delegate("#sdelete", 'click', function (e) {
                 var c = confirm('Are You sure you want to delete Subject');
				// e.preventDefault();
                 if(!c == true){
                     e.preventDefault();
                 }
             })




         });
     </script>   
        
@stop
    <!-- /. WRAPPER  -->
@stop