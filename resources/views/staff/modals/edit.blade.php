<div class="modal fade" id="updatestaff" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Staff Details</h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" method="post" action="{{url('/staff/edit')}}">
                    {{csrf_field()}}
                    <input type="hidden" id="sid" name="sid" />
            <div class="row">
                        <div class="col-lg-6">
                            <label for="first_name" class="control-label">First Name</label>
                            <input value="{{old('first_name')}}" type="text" class="form-control" id="sfname" name="first_name"
                                     required>
                        </div>
                        <div class="col-lg-6">
                            <label for="last_name" class="control-label">Last Name</label>
                            <input type="text" class="form-control" id="slname" name="last_name" value="{{old('last_name')}}" required>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-lg-6">
                                <label for="other_name" class="control-label">Other Name</label>
                                <input type="text" class="form-control" id="soname" name="other_name" value="{{old('other_name')}}">
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="control-label">Email Address/Username</label>
                                <input type="email" id="semail" class="form-control" name="email" value="{{old('email')}}" required>
                            </div>
                    </div>
                   <div class="row">
                    <div class="col-lg-6">
                        <label for="phone" class="control-label">Phone Number</label>
                        <input type="text" id="sphone" class="form-control" name="phone" value="{{old('phone')}}" required>
                    </div>
                        <div class="col-lg-12">
                            <label for="address" class="control-label">Address</label>
                            <textarea class="form-control" id="saddress" name="address" required>{{old('address')}}</textarea>
                        </div>

                   </div>
<div class="row">
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('subject') ? ' has-error' : '' }}">
                            <label for="subject" class="control-label">Teaching Subject</label>
                            <select name="subject" id="ssubject" class="form-control" required>
                                <option value=""></option>
                                @foreach($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->title}}</option>
                                @endforeach
                            </select>

                        </div>
                        </div>
                        <div class="col-lg-6">
                        <label for="post" class="control-label">Post (if any)</label>
                        <input type="text" class="form-control" id="spost" name="post" value="{{old('post')}}">
                    </div>
                        </div>

					<div class="row">
                    <h5>Class Teachers only</h5>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('class') ? ' has-error' : '' }}">
                                <label for="class" class="control-label">Class</label>
                                <select name="class" id="sclass" class="form-control" >
                                    <option value=""></option>
                                    @if(session()->get('section') == "primary")
                                    <option value="4">Primary 1</option>
                                    <option value="5">Primary 2</option>
                                    <option value="6">Primary 3</option>
                                    <option value="7">Primary 4</option>
                                    <option value="8">Primary 5</option>
                                    <option value="9">Primary 6</option>
                                    @elseif(session()->get('section') == "secondary")
                                    <option value="10">JSS 1</option>
                                    <option value="11">JSS 2</option>
                                    <option value="12">JSS 3</option>
                                    <option value="13">SS 1</option>
                                    <option value="14">SS 2</option>
                                    <option value="15">SS 3</option>
                                    @endif
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group{{ $errors->has('div') ? ' has-error' : '' }}">
                                <label for="div" class="control-label">Division (A,B,C)</label>
                                <select name="div" id="sdiv" class="form-control" id="div" >
                                    <option value=""></option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                             	</select>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Save" id="saveStd" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>




    </div>
</div>
