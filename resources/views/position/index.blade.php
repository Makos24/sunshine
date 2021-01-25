@extends('layouts.app')
@section('content')

                        <div class="container">
                            @include('position.modals.class')

                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">

<div>
    <button type="button" class="btn btn-primary" id="pos">Collate Results</button>
    <div class="btn-group">
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
            Export <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">
            <li><a target="_blank" @if(isset($data))
        href="{{url("/positionpdf/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
                   @else
                   href="#"
                   @endif
                >To PDF</a></li>
            <li><a target="_blank" @if(isset($data))
                   href="{{url("/positionexcel/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
                   @else
                   href="#"
                        @endif>To Excel</a></li>
        </ul>
    </div>
    <a target="_blank" class="btn btn-primary" id="print" @if(isset($data))
    href="{{url("/positionprint/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
        @else
        href="#"
            @endif>Print</a>
    <a target="_blank" class="btn btn-primary" id="print" @if(isset($data))
    href="{{url("/bulkterm/".$data['class']."/".$data['div']."/".$data['term']."/".$data['session'])}}"
       @else
       href="#"
            @endif>All Term Reports</a>
    {{--<a target="_blank" class="btn btn-primary" id="print" @if(isset($data))--}}
    {{--href="{{url("/bulkclass/".$data['class']."/".$data['div']."/".$data['session'])}}"--}}
       {{--@else--}}
       {{--href="#"--}}
            {{--@endif>All Session Reports</a>--}}
</div>

            </div>


                @if(isset($allPos))
            <div class="panel-body center-block">
                <h1 style="text-align: center">{{\Portal\Models\Setting::where('key','title')->first()->value}} </h1>
                <h4 style="text-transform: uppercase; text-align: center;">{{$data['ttitle']." Examination Results For ".$data['ctitle'].$data['div'].
                " ".$data['session']."/".++$data['session']." Academic Session"}}</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        
                        <thead>
                        <td>NAMES</td>
                        
                        <td>T.MRKS</td>
                        <td>AVERAGE</td>
                        <TD>POSITION</TD>
                        </thead>
                        @foreach($allPos as $k => $student)
                        <tr>
                            <td>{{$student['name']}}</td>
                        
                            <td>{{$student['total_score']}}</td>
                            <td>
                                @if(count($student['results']))
                                    {{round($student['total_score']/count($student['results']), 2)}}
                                @endif
                            </td>
                            <td>{{$student['position']}}</td>
                        </tr>

                        @endforeach
                    </table>
                </div>
            </div>
                @endif
        </div>
        </div>
        </div>
    </div>

@section('footer')
    <script type="text/javascript">
        jQuery(document).ready( function () {
            $("#pos").click( function () {
                $("#position").modal('show');
            })
        });
    </script>
    @stop
            <!-- /. PAGE INNER  -->
    <!-- /. WRAPPER  -->
@stop