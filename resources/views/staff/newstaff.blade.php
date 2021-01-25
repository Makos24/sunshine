@extends('layouts.app')
@section('content')
    <div class="container">

                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h3>Register New Staff</h3></div>
                            <div class="panel-body">
                        <form class="form-vertical" method="post" action="{{url('/staff/new')}}">
                            {{csrf_field()}}
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="first_name" class="control-label">First Name</label>
                                    <input value="{{old('first_name')}}" type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="last_name" class="control-label">Last Name</label>
                                    <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}" required>
                                </div>
                                <div class="col-lg-6">
                                    <label for="other_name" class="control-label">Other Name</label>
                                    <input type="text" class="form-control" name="other_name" value="{{old('other_name')}}">
                                </div>
                            </div>

                            <label for="email" class="control-label">Email Address</label>
                            <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
                            <label for="phone" class="control-label">Phone Number</label>
                            <input type="text" class="form-control" name="phone" value="{{old('phone')}}" required>
                            <label for="address" class="control-label">Address</label>
                            <textarea class="form-control" name="address" required>{{old('address')}}</textarea>
                            <label for="phone" class="control-label">Teaching Subject</label>
                            <select class="form-control" name="subject" required>
                                <option value=""></option>
                                @foreach($subjects as $subject)
                                <option value="{{$subject->id}}">{{$subject->title}}</option>
                                @endforeach
                            </select>
                            <label for="designation" class="control-label">Designation</label>
                            <input type="text" class="form-control" name="designation" value="{{old('designation')}}" required>

                        <div class="form-group pad-top">
                            <input type="submit" class="btn btn-primary pull-right" value="Submit">
                        </div>

                        </form>
                    </div>
                </div>
                        <!-- /. PAGE INNER  -->
                    </div>
                </div>
            </div>

    <!-- /. WRAPPER  -->
@stop