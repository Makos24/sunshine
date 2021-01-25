 @extends('layouts.app')
 @section('content')

     <div class="container">
        <div class="row">
             <div class="col-lg-6 ">
                 <div class="panel panel-default">
                     <div class="panel-heading"><h3>Register New Student</h3></div>
                     <div class="panel-body">
                         <form class="form-vertical" role="form" method="post" action="{{url("/student/new)}}">
                             {{ csrf_field() }}
                             <div class="row">
                                 <div class="col-lg-6">
                                     <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                         <label for="student_id" class="control-label">Student ID Number</label>
                                         <input type="text" name="student_id" class="form-control" id="student_id"
                                                value="{{old('student_id') }}" required>
                                         @if ($errors->has('student_id'))
                                             <span class="help-block">
<strong>{{ $errors->first('student_id') }}</strong>
</span>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-lg-6">
                                     <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                         <label for="first_name" class="control-label">First Name</label>
                                         <input type="text" name="first_name" class="form-control" id="first_name"
                                                value="{{old('first_name') }}" required>
                                         @if ($errors->has('first_name'))
                                             <span class="help-block">
<strong>{{ $errors->first('first_name') }}</strong>
</span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                         <label for="last_name" class="control-label">Last Name</label>
                                         <input type="text" name="last_name" class="form-control" id="last_name"
                                                value="{{old('last_name') }}" required>
                                         @if ($errors->has('last_name'))
                                             <span class="help-block">
<strong>{{ $errors->first('last_name') }}</strong>
</span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group{{ $errors->has('other_name') ? ' has-error' : '' }}">
                                         <label for="other_name" class="control-label">Other Name</label>
                                         <input type="text" name="other_name" class="form-control" id="other_name"
                                                value="{{old('other_name') }}" >
                                         @if ($errors->has('other_name'))
                                             <span class="help-block">
<strong>{{ $errors->first('other_name') }}</strong>
</span>
                                         @endif
                                     </div>
                                 </div>

                             </div>
                             <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                 <label for="location" class="control-label">Address</label>
                                 <textarea name="address" class="form-control" id="address" required>{{old('address')}}</textarea>
                                 @if ($errors->has('address'))
                                     <span class="help-block">
<strong>{{ $errors->first('address') }}</strong>
</span>
                                 @endif
                             </div>
                             <div class="row">
                                 <div class="col-lg-6">
                                     <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                                         <label for="level" class="control-label">Class</label>
                                         <select name="level" class="form-control" required>
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
                                         @if ($errors->has('level'))
                                             <span class="help-block">
<strong>{{ $errors->first('level') }}</strong>
</span>
                                         @endif
                                     </div>
                                 </div>
                                 <div class="col-lg-6">
                                     <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                         <label for="class" class="control-label">Division (A,B,C)</label>
                                         <input id="class" type="text" class="form-control" name="class"
                                                value="{{old('class')}}" required>
                                         @if ($errors->has('class'))
                                             <span class="help-block">
<strong>{{ $errors->first('class') }}</strong>
</span>
                                         @endif
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group">
                                 <button type="submit" class="btn btn-primary pull-right">Register</button>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
                                         <!-- /. ROW  -->

                                         <!-- /. ROW  -->
                                     </div>

     <!-- /. WRAPPER  -->
 @stop