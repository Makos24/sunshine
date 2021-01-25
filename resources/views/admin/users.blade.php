@extends('layouts.app')
@section('content')
    <div class="container">

                     @include('admin.modals.newuser')
                      @include('admin.modals.edit')
            <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Search </h3></div>
                <div class="panel-body">
                    <div class="row pull-right">
                        <button type="button" class="btn btn-info" id="newAdmin">Create New</button>
                        
                        <!--<button type="button" class="btn btn-info" id="subjectR">Subject Result</button>
                        <button type="button" class="btn btn-info" id="print">Print</button>-->
                    </div>
                    <form class="form-inline" role="search" action="{{url('/searchadmin')}}" method="">
                        <div class="form-group{{ $errors->has('student_id') ? ' has-error' : '' }}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                    <strong>{{ $errors->first('student_id') }}</strong>
                </span>
                            @endif
                            <label for="name" class="form-group">Name </label>
                            <input type="text" name="name" class="form-control " placeholder="">
                            <button type="submit" class="btn btn-default ">Search</button>
                        </div>
                    </form>
                </div>
            </div>
                    </div>


                            @if(isset($users))

                                               <table class="table table-bordered table-hover">
                    <thead style="font-weight: bold">
                    <td>S/No</td>
                    <td>Admin Name</td>
                    <td>Email</td>
                   
                    <td title="{{$i = 1}}">Actions</td>
                    </thead>
                    @foreach($users as $user)
                        <tbody>
                        <tr>
                            <td>{{$i++}}</td>
                            <td><a href="#" name="{{$user->id}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            
                            <td><div class="action">
                                    <a href="{{url("/admin/".$user->id."/edit")}}" class="fa fa-edit fa-2x" title="Edit Admin Data" name="{{$user->id}}" id="aedit"></a>
                                    <a href="{{url("/admin/".$user->id."/delete")}}" class="fa fa-trash-o fa-2x" title="Delete Admin" id="adelete" name="{{$user->id}}"></a></div></td>
                        </tr>
 
                        @endforeach
                        </tbody>
                </table>
                <div class="pager">  </div>
           

                        @endif
                        <!-- /. PAGE INNER  -->
            </div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
                 $("#newAdmin").click(function () {
                     $("#newadmin").modal('show');
                 })
				$('tbody').delegate("#aedit", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getAdmin(val);
                 $("#updateadmin").modal('show');
             })
             function getAdmin(id) {
                 $.post({
                     type: 'post',
                     url : '{{url("admin/adminJSON")}}',
                     data : {id: id},
                     success : function (data) {
                         $("#aname").val(data.name);
                         $("#aemail").val(data.email);
                         
                     },
                     error : function (data) {
                         console.log(data);
                     },
                 });
             }

             $('tbody').delegate("#adelete", 'click', function (e) {
                 var c = confirm('Are You sure you want to delete Subject');
				 e.preventDefault();
                 if(!c == true){
                     e.preventDefault();
                 }
             })
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop