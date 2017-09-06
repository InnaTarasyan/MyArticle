<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
    <footer>
        <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
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
                        {data: 'url', name: 'url'}
                    ]
                });
            });
        </script>
    </footer>
</html>