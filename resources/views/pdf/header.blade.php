<table class="noborder">
<tr>

<td colspan="3">
@if(session()->get('section') == "primary")
<h1>SUNSHINE INTERNATIONAL PRIMARY SCHOOL BAUCHI</h1>
@elseif(session()->get('section') == "secondary")
<h1>SUNSHINE INTERNATIONAL SECONDARY SCHOOL BAUCHI</h1>
@endif
</td>
</tr>
<tr>
<td>
<div class="log" id="{!! 
$link = url('/logo/'.\Portal\Models\Setting::where('key','icon')->first()->value); 
if($student->image == null){
$pic = asset("/storage/students/mm.jpg");
}else{
$pic = asset("/storage/students/".$student->image);
}  !!}">
<img src="{{asset('storage/logo.jpg')}}" width="130px" height="140px"/>
</div>
</td>
<td>
<h3></h3>
<div class="bxx">
<h5>Motto: {{\Portal\Models\Setting::where('key','motto')->first()->value}}</h5><br>
<h5>ADDRESS : <span style="color:#6279E5; font-weight:200;">{{\Portal\Models\Setting::where('key','address')->first()->value}}</span></h5>

<h5>TEL/GSM: <span style="color:#6279E5; font-weight:normal;">{{\Portal\Models\Setting::where('key','phone')->first()->value}}</span></h5>
<br>
@if(session()->get('section') == "secondary")
<h2 style="text-decoration:underline">TERMLY REPORT SHEET</h2>
@elseif(session()->get('section') == "primary")
<h2 style="text-decoration:underline">PUPIL'S REPORT SHEET</h2>
@endif
</div>
</td>
<td>
<div class="log">
<img src="{{$pic}}" width="130px" height="140px"/>
</div>
</td>
</tr>
</table>

</table>
