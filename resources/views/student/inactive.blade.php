@extends('layouts.app')
@section('content')

<div class="container">
    @include('student.modals.profile')
    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row pull-right">
                        <button type="button" class="btn btn-info" id="export">Export</button>
                        <button type="button" class="btn btn-info" id="print">Print</button>
                    </div>
                    <div class="form-inline">
                        <form class="" role="search"  method="GET">
                            <input type="text" name="search"
                                   placeholder="Enter text to search" class="form-control" >
                            <button type="submit" class="btn btn-default">Search</button>

                        </form>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">

                        @if(count($students))
        <table class="table table-bordered table-hover">
            <thead style="font-weight: bold">
            <td>S/No</td>
            <td>Student Name</td>
            <td>Class</td>
            <td>Phone Number</td>
            <td title="{{$i = 1}}">Actions</td>
            </thead>
            @foreach($students as $k => $student)
                <tbody>
                <tr>
                    <td>{{++$k}}</td>
                    <td><a href="#" name="{{$student->id}}" id="details">{{$student->getName()}}</a></td>
                    <td>{{$student->getClass()}}</td>
                    <td>{{$student->phone_number}}</td>
                    <td><div class="action">
                            <a href="{{url("/profile/".$student->id)}}" class="fa fa-file-text fa-2x" title="View Student Profile" ></a>
                            <a href="{{url("/activate/".$student->id)}}" class="fa fa-adn fa-2x" title="Activate Student" id="active" ></a>
                            <a href="{{url("/delete/".$student->id)}}" class="fa fa-trash-o fa-2x" title="Delete Student" id="delete" ></a>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
        </table>
                            <div class="pager">  {!! $students->appends(Request::get('search'))->links() !!}</div>
                        @else
                            <h4>No Inactive Students Found!!</h4>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('tbody').delegate("#details", 'click', function (e) {
                e.preventDefault();
                var val = $(this).attr("name");
                getProfile(val);
                $("#profile").modal('show');
            });
            function getProfile(id) {
                $.post({
                    type: 'post',
                    url : '/profileJSON',
                    data : {id: id},
                    success : function (data) {
                        console.log(data);
                        $("#name").html(data.name);
                        $("#id").html(data.student_id);
                        $("#clas").html(data.clas);
                        $("#email").html(data.email);
                    },
                    error : function (data) {
                        console.log(data);
                    },
                });
            }
            $('tbody').delegate("#active", 'click', function (e) {
                var c = confirm('Are You sure you want to activate Student');
                if(!c == true){
                    e.preventDefault();
                }
            })
			$('tbody').delegate("#delete", 'click', function (e) {
                var c = confirm('Are You sure you want to delete Student and all His/Her Records?');
                if(!c == true){
                    e.preventDefault();
                }
            })
        });
    </script>
    @stop
            <!-- /. PAGE INNER  -->
    <!-- /. WRAPPER  -->
@stop