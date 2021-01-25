@extends('layouts.app')
@section('content')
    <div class="container">

                @include('setting.modals.addlogo')
                    <!-- /. ROW  -->
                <h2>Term Settings</h2>
            <hr />
                    <form method="post" action="{{url('/termsettings')}}" class="form-vertical">
                        {{csrf_field()}}
                        
                    <div class="col-lg-6">
                        <div class="form-group{{ $errors->has('term') ? ' has-error' : '' }}">
                            <label for="term" class="control-label">Term</label>
                            <select name="term" class="form-control" required>
                                <option value="{{old('term') ? : $term_setting->term}}">
                                @if($term_setting->term == 1)
                                {{'First Term'}}
                                @elseif($term_setting->term == 2)
                                {{'Second Term'}}
                                @elseif($term_setting->term == 3)
                                {{'Third Term'}}
                                @endif
                                </option>
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
                                <option value="{{old('session') ? : $term_setting->session}}">{{$term_setting->session}}</option>
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

                
                        <div class="col-lg-6">
                            <label for="close_date" class="control-label">Term Ends</label>
                            <input type="text" name="close_date" class="form-control" id="dateP"
                                   value="{{old('close_date') ? : $term_setting->close_date}}" required>
                        </div>
                       
                       <div class="col-lg-6">
                            <label for="resume_date" class="control-label">Next Term Begins</label>
                            <input type="text" name="resume_date" class="form-control" id="datePi"
                                   value="{{old('resume_date') ? : $term_setting->resume_date}}" required>
                        </div>
                        
                        <div class="col-lg-2 pull-right pad-top">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Setting</button>
                        </div>
                        </div>
                    </form>
            </div>
@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function (){
            $( "#dateP" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "dd-mm-yy",
            changeMonth:true,
            changeYear:true,
        });
		
		$( "#datePi" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "dd-mm-yy",
            changeMonth:true,
            changeYear:true,
        });
        });
    </script>
@stop
@stop