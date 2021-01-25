@extends('layouts.app')
@section('content')
    <div class="container">

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="">
                                                <div class="panel panel-default">
                                                    <div class="panel-heading"><h3>Search for Students</h3></div>
                                                    <div class="panel-body">
                                                        <form class="form-inline" role="search" action="{{url("/searchprofile")}}" method="">
                                                            <div class="form-group{{ $errors->has('search') ? ' has-error' : '' }}">
                                                                @if ($errors->has('search'))
                                                                    <span class="help-block">
                                        <strong>{{ $errors->first('search') }}</strong>
                                    </span>
                                                                @endif
                                                                <label for="search" class="form-group"></label>
                                                                <input type="text" name="search" class="form-control input-lg" value="{{old('search')}}"
                                                                       placeholder="Enter Student's name or ID to search" size="50" >
                                                                <button type="submit" class="btn btn-default btn-lg">Search</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                @if(isset($students))

                                                        @foreach($students as $student)
                                                            <div class="col-md-6" style="margin-bottom: 10px">
                                                                @include('student.block')
                                                            </div>

                                                @endforeach


                                                        <!-- /. ROW  -->

                                                <!-- /. ROW  -->

                                            </div>

                                            </div>
                                            <div class="pager">  {!! $students->render() !!}</div>
                                            @else
                                            <h3>No Profiles Found</h3>
                                            @endif
                                            <!-- /. PAGE INNER  -->
                                        </div>
                                        <!-- /. PAGE WRAPPER  -->
                                    </div>


    <!-- /. WRAPPER  -->
@stop