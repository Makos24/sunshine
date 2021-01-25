<div class="row justify-content-center">
    <a href="#" class="fa fa-edit fa-2x" style='color: #31b0d5' title="Edit Student Data"
       id="btn-editStudent"
       data-student_id="{{$user->student_id}}"
       data-first_name="{{$user->first_name}}"
       data-last_name="{{$user->last_name}}"
       data-other_name="{{$user->other_name}}"
       data-gender="{{$user->gender}}"
       data-dob="{{$user->dob}}"
       data-religion="{{$user->religion}}"
       data-address="{{$user->address}}"
       data-dad_number="{{$user->dad_number}}"
       data-mum_number="{{$user->mum_number}}"
       data-level="{{$user->level}}"
       data-class="{{$user->class}}"
       data-image="{{$user->image}}"
    ></a>
    <a href="{{$url1}}" style='margin-left: 5px' class="fa fa-plus-square fa-2x" title="Add Student's Result" ></a>
    <a href="{{$url2}}" style='color: #31b0d5; margin-left: 5px' class="fa fa-file-text fa-2x" title="View Student Profile" ></a>
    <a href="{{$url3}}" style='color: #FF0000; margin-left: 5px;' class="fa fa-ban fa-2x" title="Deactivate Student" id="deact" ></a>

</div>
