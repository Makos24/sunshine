@extends('layouts.app')
@section('content')
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 ">
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Upload Student Results</h3></div>
        <div class="panel-body">

            <form class="form-vertical" role="form" method="post"
                  action="{{url('/results/upload')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option value=""></option>
                                <option value="1">First Term</option>
                                <option value="2">Second Term</option>
                                <option value="3">Third Term</option>
                            </select>
                            @if ($errors->has('term'))
                                <span class="help-block">
        <strong>{{ $errors->first('term') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('session') ? ' has-error' : '' }}">
                            <label for="session" class="control-label">Session</label>
                            <select name="session" class="form-control" required>
                                <option value=""></option>
                                @for($i = 2015; $i<= date('Y'); $i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            @if ($errors->has('session'))
                                <span class="help-block">
        <strong>{{ $errors->first('session') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>

                </div>
                @include('partials.level')

                <div class="row">
                	<div class="col-lg-6">
                        <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="control-label">Subject</label>
                            <select name="subject" class="form-control" required>
                                <option value=""></option>
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('subject'))
                                <span class="help-block">
        <strong>{{ $errors->first('subject') }}</strong>
    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('results') ? ' has-error' : '' }}">
                    <label for="results" class="control-label">Upload File</label>
                    <input type="file" name="results" class="btn btn-default" id="results" required/>
                    @if ($errors->has('results'))
                        <span class="help-block">
        <strong>{{ $errors->first('results') }}</strong>
    </span>
                    @endif
                </div>
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