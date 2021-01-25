@extends('layouts.app')
@section('content')

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3>Upload Student Details</h3></div>
                                        <div class="panel-body">

                <form class="form-vertical" role="form" method="post"
                      action="{{url("/students/upload")}}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                <label for="class" class="control-label">Class</label>
                                <select name="class" class="form-control" required>
                                    <option value=""></option>
                                    <option value="1">Nursery 1</option>
                                    <option value="2">Nursery 2</option>
                                    <option value="3">Nursery 3</option>
                                    <option value="4">Primary 1</option>
                                    <option value="5">Primary 2</option>
                                    <option value="6">Primary 3</option>
                                    <option value="7">Primary 4</option>
                                    <option value="8">Primary 5</option>
                                    <option value="9">Primary 6</option>
                                    <option value="10">JSS 1</option>
                                    <option value="11">JSS 2</option>
                                    <option value="12">JSS 3</option>
                                    <option value="13">SS 1</option>
                                    <option value="14">SS 2</option>
                                    <option value="15">SS 3</option>
                                </select>
                                @if ($errors->has('class'))
                                    <span class="help-block">
            <strong>{{ $errors->first('class') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('div') ? ' has-error' : '' }}">
                                <label for="div" class="control-label">Division (A,B,C)</label>
                                <input type="text" name="div" class="form-control" id="div" required>
                                @if ($errors->has('div'))
                                    <span class="help-block">
            <strong>{{ $errors->first('div') }}</strong>
        </span>
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="form-group{{ $errors->has('students') ? ' has-error' : '' }}">
                        <label for="students" class="control-label">Upload File</label>
                        <input type="file" name="students" class="btn btn-default" id="students" required>
                        @if ($errors->has('students'))
                            <span class="help-block">
            <strong>{{ $errors->first('students') }}</strong>
        </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary pull-right">Upload</button>
                    </div>
                </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    <!-- /. WRAPPER  -->
@stop