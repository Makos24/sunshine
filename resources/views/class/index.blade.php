@extends('layouts.app')
@section('content')

                        <div class="container">
                            @include('class.newclass')
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <button type="button" class="btn btn-info" id="aClass">Add Class</button>
                                                <button type="button" class="btn btn-info" id="upClass">Add Class List</button>
                                                <button type="button" class="btn btn-info" id="export">Export</button>
                                                <button type="button" class="btn btn-info" id="print">Print</button>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="table-responsive">

                                                @if(isset($classes))
                                                    <table class="table table-bordered table-hover">
                                                        <thead style="font-weight: bold">
                                                        <td>S/No</td>
                                                        <td>Class Name</td>
                                                        <td>Section</td>
                                                        <td>Actions</td>
                                                        </thead>
                                                        @foreach($classes as $k => $class)
                                                            <tbody>
                                                            <tr>
                                                                <td>{{++$k}}</td>
                                                                <td>{{$class->name}}</td>
                                                                <td>{{$class->section}}</td>
                                                                <td><div class="action">
                                                                        <a href="{{url("/class/".$class->id."/edit")}}" class="fa fa-edit fa-2x" title="Edit Class Data">
                                                                        </a><a href="{{url("/class/".$class->id."/delete")}}" class="fa fa-recycle fa-2x" title="Delete Class" name="{{$class->id}}"></a></div></td>
                                                            </tr>

                                                            @endforeach
                                                            </tbody>
                                                    </table>
                                                    <div class="pager"></div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /. ROW  -->


@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function () {
            $("#aClass").click( function () {
                $("#addClass").modal('show');
            })
        });
    </script>
    @stop
            <!-- /. PAGE INNER  -->
    <!-- /. WRAPPER  -->
@stop