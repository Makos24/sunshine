@extends('layouts.app')
@section('content')
    <div class="container">

                @include('setting.modals.addlogo')
                    <!-- /. ROW  -->
                <h2>Application Settings</h2>
            <hr />
                    <form method="post" action="{{url('/settings')}}" class="form-vertical">
                        {{csrf_field()}}
                        <div class="col-lg-10">
                            <label for="title" class="control-label">NAME OF SCHOOL</label>
                            <input type="text" name="title" class="form-control"
                                  placeholder="Name of School Here" id="title"
                                   value="{{$setting[0]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="address" class="control-label">ADDRESS</label>
                            <textarea class="form-control" name="address">{{$setting[1]}}</textarea>
                        </div>
                        <div class="col-lg-10">
                            <label for="phone" class="control-label">PHONE NUMBER</label>
                            <input type="text" name="phone" class="form-control"
                                   placeholder="Phone Number" id="title"
                                   value="{{$setting[2]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="email" class="control-label">EMAIL ADDRESS</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="Email Address" id="title"
                                   value="{{$setting[3]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="footer" class="control-label">SCHOOL MOTTO</label>
                            <input type="text" name="footer" class="form-control"
                                   placeholder="School motto" id="title"
                                   value="{{$setting[4]}}" required>
                        </div>
                        <div class="col-lg-10">
                            <label for="icon" class="control-label">SCHOOL LOGO</label>
                            <div class="form-inline">
                            <input type="text" name="icon" class="form-control"
                                   placeholder="School logo" id="title"
                                   value="{{$setting[5]}}" size="79" disabled required>
                            <button type="button" class="btn btn-primary" id="icon">Upload Logo</button>
                            </div>
                        </div>
                        <div class="col-lg-3 pull-right pad-top">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Setting</button>
                        </div>
                        </div>
                    </form>
            </div>

@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function (){
            $("#icon").click( function () {
                $("#iconprev").attr('src', '{{url("/logo/logo.jpg")}}');
                $("#addlogo").modal('show');
            });
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#iconprev').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $("#logoFile").change(function(){
                readURL(this);
            });
            $('#frmLogo').on('submit', function(e) {
                e.preventDefault(); // prevent native submit
                $(this).ajaxSubmit({
                    complete: function(xhr) {
                        alert(xhr.responseJSON.info);
                        console.log(xhr.responseJSON.info);
                    }
                })
                $("#logoFile").val('');
            });

        });
    </script>
@stop
@stop