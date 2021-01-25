@extends('layouts.app')
@section('content')
    <div class="container">

            
            <h2>{{$data['class'].' Attendance For '.$data['term'].' Term '.$data['session'].'/'.++$data['session'].' Session'}}</h2>
<table cellspacing="0" class="table table-bodered">
    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Present</th>
        <th>Absent</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $k => $r)
    <tr>
        <td>{{++$k}}</td>
        <td>{{$r['id']}}</td>
        <td>{{$r['name']}}</td>
        <td>{{$r['present']}}</td>
        <td>{{$r['total']-$r['present']}}</td>
        <td>{{$r['total']}}</td>
    </tr>
    @endforeach
    </tbody>
</table>
             </div>
           <!-- /. PAGE INNER  -->

    @section('footer')
         <script type="text/javascript">
             jQuery(document).ready( function () {
                 $("#addR").click(function () {
                     $("#addresult").modal('show');
                 })
				 
             })
         </script>   
    @stop
        <!-- /. PAGE WRAPPER  -->

    <!-- /. WRAPPER  -->
@stop