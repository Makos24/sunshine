@extends('layouts.app')
@section('content')

                        <div class="container">
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <div class="row pull-right">
                                                <button type="button" class="btn btn-info" id="add">Add Student</button>
                                                <button type="button" class="btn btn-info" id="up">Add Student List</button>
                                                <button type="button" class="btn btn-info" id="export">Export</button>
                                                <button type="button" class="btn btn-info" id="print">Print</button>
                                            </div>
                                            <div class="form-inline">
                                                <form class="" role="search" action="/searchstudent" method="">
                                                    <input type="text" name="search"
                                                           placeholder="Enter text to search" class="form-control" >
                                                    <button type="submit" class="btn btn-default">Search</button>
                                                    <select class="form-control" id="level">
                                                        <option value=""></option>
                                                        <option value="all">All Classes</option>
                                                        <option value="1">JSS 1</option>
                                                        <option value="2">JSS 2</option>
                                                        <option value="3">JSS 3</option>
                                                        <option value="4">SS 1</option>
                                                        <option value="5">SS 2</option>
                                                        <option value="6">SS 3</option>
                                                    </select>
                                                </form>

                                            </div>
                                        </div>
                                        <div class="panel-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



@stop