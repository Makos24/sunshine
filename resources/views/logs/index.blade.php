@extends('layouts.app')
@section('content')

                <div class="container">
                    
<div class="row">
    <div class="col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                
                <div class="form-inline">
                    <form class="" role="search" action="{{url("/searchlogs")}}" method="">
                        <input type="text" name="search"
                               placeholder="Enter text to search" class="form-control" >
                        <button type="submit" class="btn btn-default">Search</button>
                    </form>


                </div>
            </div>
<div class="panel-body">
<div class="table-responsive">

@if(isset($l))
    <table class="table table-bordered table-hover">
        <thead style="font-weight: bold">
        <td>S/No</td>
        <td>User Name</td>
        <td>Action</td>
        <td>Date and Time</td>
       
        </thead>
    @foreach($l as $k => $log)
    <tbody>
    <tr>
        <td>{{++$k}}</td>
        <td>{{$log['user']}}</td>
        <td>{{$log['action']}}</td>
        <td>{{$log['time']}}</td>
    </tr>
    @endforeach
    </tbody>
    </table>
    <div class="pager">  {!! $l->render() !!}</div>
@endif
    </div>

</div>
        </div>
    </div>
</div>
</div>
        @section('footer')

@stop
<!-- /. PAGE INNER  -->
<!-- /. WRAPPER  -->
@stop