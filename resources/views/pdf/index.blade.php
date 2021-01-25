@extends('layouts.app')
@section('content')
    <div class="container">

                        <h2>Generate Score sheets</h2>
                        <hr />
                        <form method="post" action="{{url('/scoresheetinput')}}" class="form-vertical">
                            {{csrf_field()}}
                            @include('partials.level')
                            <div class="form-group pad-top">
                                <input type="submit" class="btn btn-primary" value="Generate Scoresheet">
                            </div>

                        </form>
                    </div>
                    <!-- /. PAGE INNER  -->

@stop