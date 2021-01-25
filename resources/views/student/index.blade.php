@extends('layouts.app')
@section('content')
    <div id="">
        @include('partials.nav')

        <!-- /. NAV SIDE  -->

                            <!-- /. NAV SIDE  -->


                                            <!-- /. ROW  -->
                <div class="container">
                    @include('student.modals.newstudent')
                    @include('student.modals.editstudent')
                    @include('student.modals.uploadstudents')
                    @include('student.modals.profile')
                    @include('student.modals.excel')
                    @include('student.modals.pdf')
                    @include('student.modals.export')
                    @include('student.modals.biodata')
                    @include('student.modals.classsheet')
                    @include('student.modals.addmany')
                    @include('student.modals.export-email')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <button type="button" class="btn btn-primary" id="add">Add Student</button>
                    <button type="button" class="btn btn-primary" id="addM">Add Many</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Emails <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a id="up" href="#">Add/Edit Emails</a></li>
                            <li><a data-toggle="modal" data-target="#emailExport" href="#">Export Emails By Class</a></li>
                            <li><a href="{{url('emails/export-all')}}">Export All Emails</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            Export <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a target="_blank" id="pdfBtn" href="#">Subject Score Sheet</a></li>
                            <li><a target="_blank" id="classBtn" href="#">Class Score Sheet</a></li>
                            <li><a target="_blank" href="#" id="excelBtn" >To Excel</a></li>
                        </ul>
                    </div>
                    <a target="_blank" class="btn btn-primary" id="bioData">Bio Data</a>
                </div>

            </div>
<div class="panel-body">
    <div class="table-responsive">


        <table class="table table-bordered" id="admin-students-table">
            <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Parents Mobile</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Class</th>
                <th>Parents Mobile</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>

    </div>

</div>
        </div>
    </div>
</div>
</div>
                            <!-- /. ROW  -->

                            <!-- /. ROW  -->
                        </div>
                        <!-- /. PAGE INNER  -->
                    </div>
                    <!-- /. PAGE WRAPPER  -->
                </div>
            </div>
        </div>
        @section('footer')
<script type="text/javascript">
    jQuery(document).ready( function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var oTable = $('#admin-students-table').DataTable({
            saveState: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{url('students/data')}}',
                data: function (d) {
                    d.gender = $('select[name=genders]').val();
                    d.level = $('select[name=level]').val();
                    d.div = $('select[name=div]').val();
                }
            } ,
            columns: [
                { data: 'student_id'},
                { data: 'name'},
                { data: 'gender'},
                { data: 'class'},
                { data: 'dad_number'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            columnDefs: [
                { "width": "15%", "targets": 5 }
            ]
        });

        var c;

        $("#up").click(function () {
            $('#studentupload').modal('show');
        });

        $(document).on('click', "#btn-editStudent", 'click', function (e) {
            e.preventDefault();
            $("#idHid").val($(this).data('student_id'));
            if($(this).data('image')){
                var dee = $(this).data('image');
                $("#picture").attr('src', '{{url("/")}}'+"/student/view/"+dee);
            }else{
                $("#picture").attr('src', '{{url("/student/mm.jpg/view")}}');
            }
            $("#estudent_id").val($(this).data('student_id'));
            $("#efirst_name").val($(this).data('first_name'));
            $("#elast_name").val($(this).data('last_name'));
            $("#eother_name").val($(this).data('other_name'));
            $("#eaddress").html($(this).data('address'));
            $("#eclass").val($(this).data('class'));
            $("#elevel").val($(this).data('level'));
            //$("#elevel").selected($(this).data('level'));
            $("#eemail").val($(this).data('email'));
            $("#datepicker").val($(this).data('dob'));
            $("#egender").val($(this).data('gender'));
            //$("#egender").selected($(this).data('gender'));
            $("#ereligion").val($(this).data('religion'));
            //$("#ereligion").selected($(this).data('religion'));
            $("#edad_number").val($(this).data('dad_number'));
            $("#emum_number").val($(this).data('mum_number'));

            $('#editStudent').modal('show');
        });
        $('tbody').delegate("#details", 'click', function (e) {
            e.preventDefault();
            var val = $(this).attr("name");
            getProfile(val, 1);
			console.log($("#picture").attr('src'));
            $("#profile").modal('show');
			
        });
        function getProfile(id, p) {
            $.post({
                type: 'post',
                url : '{{url("/profileJSON")}}',
                data : {id: id},
                success : function (data) {
                    console.log(data);
                    if(p == 1){
                        if(data.image){
                            var dee = data.image;
                            $("#profimg").attr('src', '{{url("/")}}'+"/student/view/"+dee);
                        }else{
                            $("#profimg").attr('src', '{{url("/student/mm.jpg/view")}}');
                        }
                        $("#name").html(data.name);
                        $("#id").html(data.student_id);
                        $("#clas").html(data.clas);
                        $("#email").html(data.email);
                        $("#dob").html(data.dob);
                        $("#pgender").html(data.gen);
                        $("#phone").html('Dad: '+data.dad_number+' Mum: '+ data.mum_number);
                        $("#preligion").html(data.rel);
                        $("#addr").html(data.address);
                    }else if(p == 2){
                    $("#idHid").val(data.student_id);
					if(data.image){
                        var dee = data.image;
                        $("#picture").attr('src', '{{url("/")}}'+"/student/view/"+dee);
                    }else{
                        $("#picture").attr('src', '{{url("/student/mm.jpg/view")}}');
                    }
                        $("#estudent_id").val($(this).data('student_id'));
                        $("#efirst_name").val($(this).data('first_name'));
                        $("#elast_name").val($(this).data('last_name'));
                        $("#eother_name").val($(this).data('other_name'));
                        $("#eaddress").html($(this).data('address'));
                        $("#eclass").val($(this).data('class'));
                        $("#elevel").val($(this).data('level'));
                        //$("#elevel").selected($(this).data('level'));
                        $("#eemail").val($(this).data('email'));
                        $("#datepicker").val($(this).data('dob'));
                        $("#egender").val($(this).data('gender'));
                        //$("#egender").selected($(this).data('gender'));
                        $("#ereligion").val($(this).data('religion'));
                        //$("#ereligion").selected($(this).data('religion'));
                        $("#edad_number").val($(this).data('dad_number'));
                        $("#emum_number").val($(this).data('mum_number'));
                    }
                },
                error : function (data) {
                    console.log(data);
                },
            });
        }
        $('tbody').delegate("#deact", 'click', function (e) {
            var c = confirm('Are You sure you want to deactivate Student');
            if(!c == true){
                e.preventDefault();
            }
        });
		$("#bioData").click(function (e) {
            e.preventDefault();
            $("#biodata").modal('show');
        });
		$("#addM").click(function (e) {
            e.preventDefault();
            $("#addmany").modal('show');
        });
        $("#pdfBtn").click(function (e) {
            e.preventDefault();
            $("#pdf").modal('show');
        });
        $("#excelBtn").click(function (e) {
            e.preventDefault();
            $("#excel").modal('show');
        });
        $("#printBtn").click(function (e) {
            e.preventDefault();
            $("#print").modal('show');
        });
		$("#classBtn").click(function (e) {
            e.preventDefault();
            $("#classSheet").modal('show');
        });
        $( "#datepicker" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
        });
        $( "#dobdatepicker" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
        });
        $( "#regdatepicker" ).datepicker({
            beforeShow: function(input, inst) {
                $(document).off('focusin.bs.modal');
            },
            onClose:function(){
                $(document).on('focusin.bs.modal');
            },
            dateFormat: "yy-mm-dd",
            changeMonth:true,
            changeYear:true,
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#picture').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#uploadFile").change(function(){
            readURL(this);
        });

        $('#frmPic').on('submit', function(e) {
            e.preventDefault(); // prevent native submit
            $(this).ajaxSubmit({
                complete: function(xhr) {
					alert(xhr.responseJSON.info);
                    console.log(xhr.responseJSON.info);
                }
            })
            $("#uploadFile").val('');
        });
//        $('#eStd').on('submit', function(e) {
//            e.preventDefault(); // prevent native submit
//            $(this).ajaxSubmit({
//                success: function(xhr) {
//                    //alert(xhr.responseJSON.info);
//                    console.log(xhr);
//                }
//            })
//        });
});
</script>
@stop
<!-- /. PAGE INNER  -->
<!-- /. WRAPPER  -->
@stop