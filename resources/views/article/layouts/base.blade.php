<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <meta name="_token" content="{{ csrf_token() }}">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container" style="padding-top:5%">
            @yield('content')
        </div>
        <input type="hidden" id="mytoken" value="{{ csrf_token() }}">
        <input type="hidden" id="myroute" value="{{ route('datatable.getposts') }}">
        <input type="hidden" id="publicpath" value="{{ asset('img/') }}">
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
    </footer>
</html>