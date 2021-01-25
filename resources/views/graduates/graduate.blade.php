@extends('layouts.app')
@section('content')

                <div class="container">
                    @include("graduates.gradgeoption")
                    <div class="row">
                        <h2>Graduate Final Year Students</h2>
                        <hr />
                        <div class="col-md-9">

                            @if(count($students))
                                <table class="table table-bordered">
                                    <thead>
                                    <td width="20px">
                                        <div class="checkbox-inline">
                                            <input type="checkbox" name="all" class="checkbox-inline" id="all">
                                            <label for="all" class="label label-primary">Check All</label>
                                        </div>

                                    </td>
                                    <td>S/No</td>
                                    <td>Student Name</td>
                                    <td>Admission No.</td>
                                    <td>Class</td>
                                    <td>Graduate</td>
                                    </thead>
                                    <form action="{{url('/students/graduate')}}" method="post" name="" id="promform">
                                        {{csrf_field()}}
                                        @foreach($students as $student)
                                            <tr>
                                                <td><input type="checkbox" name="names[]" value="{{$student->id}}"></td>
                                                <td>{{$student->id}}</td>
                                                <td>{{$student->getName()}}</td>
                                                <td>{{$student->student_id}}</td>
                                                <td>{{$student->getClass()}}</td>
                                                <td><div class="action">
                                                        </a><a href="{{url("/graduate/".$student->id)}}" class="fa fa-graduation-cap fa-2x" title="Graduate Student"></a></div></td>
                                            </tr>

                                    @endforeach
                                </table>
                                {{--<div class="pager">  {!! $students->appends(Request::get('search'))->links() !!}</div>--}}
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="year" class="control-label">Graduation Year</label>
                                        <select name="year" class="form-control" required>
                                            <option value=""></option>
                                            @for($i = 2015; $i<= date('Y'); $i++)
                                                <option value="{{$i}}">{{$i."/".++$i}}</option>
                                            @endfor
                                        </select>

                                    </div>

                                </div>
                                <button type="submit" id="graduate" class="btn btn-primary">Graduate Selected</button>
                                </form>
                                @else
                                <h4>{{"No Final Year Students Yet!"}}</h4>
                            @endif


                        </div>
                    </div>
                </div>

@section('footer')
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            var all = $("input:checkbox#all");
            var c = $("input:checkbox:not(input:checkbox#all)");

            all.on('click', function () {
                console.log(all.prop("checked"));
                if(all.prop("checked") === true){
                    c.attr("checked", "checked");
                    //all.val(["off"]);
                }else{
                    c.removeAttr("checked")
                }
            });
            $("#graduate").on('click', function (e) {
                var id = [];
                //c.each( function () {
                id = $("input:checkbox:checked:not(input:checkbox#all)");
                data = id.serialize();
                if(data === ""){
                    e.preventDefault();
                    alert('No Student selected');
                }
                console.log(data);
//        $.ajax({
//                    type : 'post',
//                    url : '/promote',
//                    data: data,
//                    success : function (data) {
//                        console.log(data);
//                    },
//                    error : function (data) {
//                        console.log(data);
//                    }
//                }
//
//        )

            });

        });
    </script>
    @stop
            <!-- /. PAGE INNER  -->

    <!-- /. WRAPPER  -->
@stop