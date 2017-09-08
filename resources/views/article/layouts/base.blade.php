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
        <div id="delModal" class="modal fade">
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
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="{{ URL::asset('js/article/article.js')}}"></script>
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
                        {data: 'action', name: 'action'}
                    ],
                    "columnDefs" : [{
                        "targets" : 3 ,
                        "data": "main_image",
                        "render" : function ( url, type, full) {
                           return  '<img src="http://www.tert.am/news_images/826/2477835_1/8e32f749936471e696b1802b2d391fd7_3131.jpg" alt="" width="96" height="63">'
                        }}],
                    "pageLength": 5
                });



                $('#delModal').on('hidden.bs.modal', function(event) {
                    $( ".editform" ).remove();
                });

                $('#delModal').on('show.bs.modal', function(e) {
                    if(e.relatedTarget != undefined){
                        var target = e.relatedTarget;
                        var id = target.id;


                        if($(target).hasClass("edit") || $(target).hasClass("add") ){
                            var title =  $(e.relatedTarget).data('article-title') || '';
                            var description =  $(e.relatedTarget).data('article-description') || '';
                            var main_image =  $(e.relatedTarget).data('article-main_image') || '';
                            var data =  $(e.relatedTarget).data('article-data') || '';
                            var url =  $(e.relatedTarget).data('article-url') || '';

                            var text = ' <div class="editform">' +
                                ' <div class="form-group editform">\n' +
                                '    <label for="title">Title:</label>\n' +
                                '    <input  class="form-control" id="title" value='+ title +'>\n' +
                                '  </div>\n' +
                                ' <div class="form-group editform">\n' +
                                '    <label for="description">Description:</label>\n' +
                                '    <textarea  class="form-control" id="description" rows="2" cols="2" >'+ description + '</textarea>\n' +
                                '  </div>\n' +
                                ' <div class="form-group editform">\n' +
                                '    <label for="main_image">Main Image:</label>\n' +
                                '    <input  class="form-control" id="main_image" value='+ main_image +'>\n' +
                                '  </div>\n' +
                                ' <div class="form-group editform">\n' +
                                '    <label for="data">Data:</label>\n' +
                                '    <input  class="form-control" id="data" value='+ data +'>\n' +
                                '  </div>\n' +
                                ' <div class="form-group editform">\n' +
                                '    <label for="url">Url:</label>\n' +
                                '    <input  class="form-control" id="url" value='+ url +'>\n' +
                                '  </div>\n' +
                                ' </div>';
                            $('.modal-body').append(text);
                        } else if ($(target).hasClass("delete") && $('.editform')[0]) {
                            $( ".editform" ).remove();
                        }

                        $(document).on('click', '.save', function(){
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
                                            $('#delModal').modal('toggle');
                                        }
                                    },
                                    error: function (data) {
                                        console.log(data);
                                    }
                                });
                            } else if($(target).hasClass("edit")){
                                var new_title = $('#title').val();
                                var new_description = $('#description').val();
                                var new_main_image = $('#main_image').val();
                                var new_data = $('#data').val();
                                var new_url = $('#url').val();


                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: id,
                                        title: new_title,
                                        description: new_description,
                                        main_image: new_main_image,
                                        data: new_data,
                                        url: new_url,
                                        _method: 'PATCH',
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    url: "articles/"+id,
                                    success: function (data) {
                                        if(data.status == 'ok'){
                                            oTable.ajax.reload();
                                            $('#delModal').modal('toggle');
                                        }
                                    },
                                    error: function (data) {
                                        console.log(data);
                                    }
                                });

                            }  else if($(target).hasClass("add")) {

                                var new_title = $('#title').val();
                                var new_description = $('#description').val();
                                var new_main_image = $('#main_image').val();
                                var new_data = $('#data').val();
                                var new_url = $('#url').val();


                                $.ajax({
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {
                                        id: id,
                                        title: new_title,
                                        description: new_description,
                                        main_image: new_main_image,
                                        data: new_data,
                                        url: new_url,
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    url: "articles",
                                    success: function (data) {
                                        if(data.status == 'ok'){
                                            oTable.ajax.reload();
                                            $('#delModal').modal('toggle');
                                        }
                                    },
                                    error: function (data) {
                                        console.log(data);
                                    }
                                });
                            }
                        });
                    }
                });
            });

        </script>
    </footer>
</html>