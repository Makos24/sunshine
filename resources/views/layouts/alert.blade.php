@if(Session::has('info'))
<div class="row">
	<div class="col-lg-12">
    	<div class="alert alert-info" role="alert" id="info">
        {{Session::get('info')}}
    	</div>
     </div>
</div>     
@elseif(Session::has('error'))
    <div class="alert alert-error" role="alert" id="error">
        {{Session::get('error')}}
    </div>
@endif