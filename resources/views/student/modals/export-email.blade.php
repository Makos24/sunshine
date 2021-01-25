<div class="modal fade" id="emailExport" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Export Parent Emails </h4>
            </div>
            <div class="modal-body">
                <form class="form-vertical" role="form" method="post"
                      action="{{url("/students/export-emails")}}" >
                    {{ csrf_field() }}
                    @include('partials.level')

                    <div class="modal-footer">
                        <input type="submit" value="Save" id="saveStd" class="btn btn-primary">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>