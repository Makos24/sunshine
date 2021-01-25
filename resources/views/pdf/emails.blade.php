<!DOCTYPE html>
<html lang="en">
<h1>{{\Portal\Models\Setting::where('key','title')->first()->value}}</h1>
<h2>Emails List</h2>
<table cellspacing="0">
    <thead>
    <tr>
        <th>S/No</th>
        <th>Admission Number</th>
        <th>Student Name</th>
        <th>Class</th>
        <th>Email</th>
        <th>Alt Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($students as $k => $student)
        <tr>
            <td>{{++$k}}</td>
            <td>{{$student->student_id}}</td>
            <td>{{$student->getName()}}</td>
            <td>{{$student->getClass()}}</td>
            <td>{{$student->email}}</td>
            <td>{{$student->alt_email}}</td>
        </tr>
    @endforeach
    </tbody>

</table>

</html>