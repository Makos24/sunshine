@extends('layouts.app')
@section('content')

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6 ">
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><h3>Add New Subject</h3></div>
                                        <div class="panel-body">

                    <form class="form-vertical" role="form" method="post" action="{{url("/subject/new")}}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="control-label">Subject Name</label>
                            <input id="title" type="text" class="form-control" name="title"
                                   value="{{old('title')}}" required>
                            @if ($errors->has('title'))
                                <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('section') ? ' has-error' : '' }}">
                            <label for="section" class="control-label">Section</label>
                            <input id="section" type="text" class="form-control" name="section"
                                   value="{{session()->get('section')}}" readonly>
                            @if ($errors->has('section'))
                                <span class="help-block">
                <strong>{{ $errors->first('section') }}</strong>
            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary pull-right fa-save">Save</button>
                        </div>
                    </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

    <!-- /. WRAPPER  -->
@stop



