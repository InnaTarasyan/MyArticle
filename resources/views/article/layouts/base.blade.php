<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container" style="padding-top:5%">
            @yield('content')
        </div>
        <!-- Modal HTML -->
        <div id="myModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to apply the changes?</p>
                        <p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary save">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <footer>
        <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                oTable = $('#articles').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": "{{ route('datatable.getposts') }}",
                    "columns": [
                        {data: 'id', name: 'id'},
                        {data: 'title', name: 'title'},
                        {data: 'description', name: 'description'},
                        {data: 'main_image', name: 'main_image'},
                        {data: 'data', name: 'data'},
                        {data: 'url', name: 'url'},
                        {data: 'action', name: 'action'},
                    ]
                });

                $('#myModal').on('show.bs.modal', function(e) {
                    if(e.relatedTarget != undefined){
                        var target = e.relatedTarget;
                        var id = target.id;

                        $(document).click('.save', function(){
                            if($(target).hasClass("delete")){
                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: id,
                                        _method: 'DELETE',
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    url: "articles/"+id,
                                    success: function (data) {
                                        if(data.status == 'ok'){
                                            oTable.ajax.reload();
                                            $('#myModal').modal('toggle');
                                        }
                                    },
                                    error: function (data) {
                                        console.log(data);
                                    }
                                });
                            } else if($(target).hasClass("edit")){
                                debugger;
                            }
                        });
                    }
                });
            });

        </script>

    </footer>
</html>