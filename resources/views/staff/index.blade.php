@extends('layouts.app')
@section('content')
    <div class="container">

                <div class="row">
                    @include('staff.modals.newstaff')
                    @include('staff.modals.edit')
                    @include('staff.modals.details')
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
        <div class="row pull-right">
            <button type="button" class="btn btn-info" id="newStaff">Add Staff</button>
            <!--<button type="button" class="btn btn-info" id="up">Import Staff List</button>
            <button type="button" class="btn btn-info" id="export">Export</button>
            <button type="button" class="btn btn-info" id="print">Print</button>-->
        </div>
        <div class="form-inline">
            <form class="" role="search" action="{{url('/searchstaff')}}" method="">
                <input type="text" name="search"
                       placeholder="Enter text to search" class="form-control" >
                <button type="submit" class="btn btn-default">Search</button>
            </form>

        </div>
    </div>
    <div class="panel-body">
        <div class="table-responsive">

    @if(isset($staffs))
        <table class="table table-bordered table-hover">
            <thead style="font-weight: bold">
            <td>S/No</td>
            <td>Staff Name</td>
            <td>Email</td>
            <td>Phone Number</td>
            <td title="{{$i = 1}}">Actions</td>
            </thead>
            @foreach($staffs as $staff)
                <tbody>
                <tr>
                    <td>{{$i++}}</td>
                    <td><a id="sdetails" href="#" name="{{$staff->id}}">{{$staff->getName()}}</a></td>
                    <td>{{$staff->email}}</td>
                    <td>{{$staff->phone_number}}</td>
                    <td><div class="action">
                   <a href="#" class="fa fa-edit fa-2x"
                   title="Edit Staff Data" id="sedit" name="{{$staff->id}}"></a>
                   <a href="{{url("/staff/".$staff->id."/delete/")}}" class="fa fa-trash-o fa-2x"
                    title="Delete Staff" id="sdelete" name="{{$staff->id}}"></a></div></td>
                </tr>

                @endforeach
                </tbody>
        </table>
        <div class="pager">  {!! $staffs->appends(Request::get('search'))->links() !!}</div>
            @endif
        </div>

    </div>
                                </div>
                            </div>
                        </div>
            <!-- /. PAGE INNER  -->
                        </div>
                </div>
            </div>
    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
                 $("#newStaff").click(function () {
                     $("#newstaff").modal('show');
                 })

				 $('tbody').delegate("#sdetails", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getStaff(val, 2);
                 $("#sdetails").modal('show');
             })

				$('tbody').delegate("#sedit", 'click', function (e) {
                 e.preventDefault();
                 var val = $(this).attr("name");
                 getStaff(val, 1);
                 $("#updatestaff").modal('show');
             })
             function getStaff(id, op) {
                 $.post({
                     type: 'post',
                     url : '{{url("admin/staffJSON")}}',
                     data : {id: id},
                     success : function (data) {
						  console.log(data);
						  if(op === 1){
                        $("#sid").val(data.sid);
                         $("#sfname").val(data.fname);
                         $("#slname").val(data.lname);
                         $("#soname").val(data.oname);
                         $("#semail").val(data.email);
                         $("#sphone").val(data.phone);
                         $("#saddress").val(data.address);
						 $("#ssubject").val(data.sub);
						 $("#sclass").val(data.level);
						 $("#sdiv").val(data.div);
						  }else if(op === 2){
						$("#sname").html(data.name);
                         $("#sem").html(data.email);
                         $("#sph").html(data.phone);
                         $("#saddr").html(data.address);
						 $("#ssub").html(data.subject);
						 $("#scl").html(data.cl+data.div);



							  }

                     },
                     error : function (data) {
                         console.log(data);
                     },
                 });
             }

             $('tbody').delegate("#sdelete", 'click', function (e) {
                 var c = confirm('Are You sure you want to delete Staff Data');
                 if(!c == true){
                     e.preventDefault();
                 }
             })
             })
         </script>
    @stop
@stop
