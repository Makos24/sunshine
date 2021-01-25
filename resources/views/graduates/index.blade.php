@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row pull-right">
                        <button type="button" class="btn btn-info" id="export">Export</button>
                        <button type="button" class="btn btn-info" id="print">Print</button>
                    </div>
                    <div class="form-inline">
                        <form class="" role="search" action="{{url('/searchgraduate')}}" method="">
                            <input type="text" name="search"
                                   placeholder="Enter year to search" class="form-control" >
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
                                <td>Year of Grad</td>
                                <td>Phone Number</td>
                                <td title="{{$i = 1}}">Actions</td>
                                </thead>
                                @foreach($students as $student)
                                    <tbody>
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td><a href="#" name="{{$student->id}}" id="details">{{$student->getName()}}</a></td>
                                        <td>{{$student->leave_year}}</td>
                                        <td>{{$student->phone_number}}</td>
                                        <td><div class="action">
   <a href="{{url("/profile/".$student->id)}}" class="fa fa-file-text fa-2x" title="View Student Profile" name="{{$student->id}}"></a></div></td>
                                    </tr>

                                    @endforeach
                                    </tbody>
                            </table>
                            {{--<div class="pager">  {!! $students->appends(Request::get('search'))->links() !!}</div>--}}
                        @else
                            <h4>{{"No Graduates Yet!"}}</h4>
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

});
</script>
@stop
<!-- /. PAGE INNER  -->
<!-- /. WRAPPER  -->
@stop