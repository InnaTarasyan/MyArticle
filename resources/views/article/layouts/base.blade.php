<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <meta name="_token" content="{{ csrf_token() }}">
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
    </head>
    <body>
        <div class="container" style="padding-top:5%">

            <div class="container" style="padding-bottom: 10%;">
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6' style="z-index: 1">
                            <input type='text' class="form-control" placeholder="Start Date"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7' style="z-index: 1">
                            <input type='text' class="form-control" placeholder="End Date"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" id="search_btn" class="btn btn-primary">Search...</button>
                </div>
                <div class='col-md-5'>
                    <div style="padding-bottom: 5%; padding-top: 5%;">
                        <div class="dropdown" >
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                How many total items to see? <span id="totalCount">(1000)</span>
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu total_count">
                                <li><a href="#">10</a></li>
                                <li><a href="#">20</a></li>
                                <li><a href="#">30</a></li>
                                <li><a href="#">40</a></li>
                                <li><a href="#">50</a></li>
                                <li><a href="#">100</a></li>
                                <li><a href="#">200</a></li>
                                <li><a href="#">300</a></li>
                                <li><a href="#">500</a></li>
                                <li><a href="#">1000</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
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
                        <button type="button" class="btn btn-primary save" id="save_article">Save changes</button>
                    </div>
                </div>
            </div>
        </div>


    </body>
    <footer>
        <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
        <!-- Latest compiled JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(function () {
                $('#datetimepicker6').datetimepicker({
                    format: 'YYYY/MM/DD'
                });
                $('#datetimepicker7').datetimepicker({
                    useCurrent: false, //Important! See issue #1075
                    format: 'YYYY/MM/DD'
                });
                $("#datetimepicker6").on("dp.change", function (e) {
                    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function (e) {
                    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });
            });
        </script>
        <script src="{{ URL::asset('js/article/article.js')}}"></script>
    </footer>
</html>