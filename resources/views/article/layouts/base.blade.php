<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <meta name="_token" content="{{ csrf_token() }}">
        <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/modal.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.css">
    </head>
    <body>
    <div id="navbar-main">

        <div style="text-align: right; padding-right: 2%;padding-top: 2%;">
            <select class="selectpicker" onchange="myFunction()" data-width="fit"  id="langs" name="langs" >
                <option data-content='<span class=""></span> {{ trans('settings.select_language') }}'>" select</option>
                <option data-content='<span  class="flag-icon flag-icon-am"></span> Armenian' data-href="{{ URL::to('setlocale/am') }}" >am</option>
                <option data-content='<span  class="flag-icon flag-icon-us"></span> English' data-href="{{ URL::to('setlocale/en')}}">en</option>
            </select>
        </div>

        <div class="container" style="padding-top:5%">
            <div class="container" style="padding-bottom: 5%;">
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker6' style="z-index: 1">
                            <input type='text' class="form-control" placeholder="{{ trans('settings.start_date') }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-5'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker7' style="z-index: 1">
                            <input type='text' class="form-control" placeholder="{{ trans('settings.end_date') }}"/>
                            <span class="input-group-addon">
                              <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" id="search_btn" class="btn btn-primary"> {{ trans('settings.search') }}...</button>
                </div>
                <div class='col-md-5'>
                    <div style="padding-bottom: 5%; padding-top: 5%;">
                        <div class="dropdown" >
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                 {{ trans('settings.total') }} <span id="totalCount">(1000)</span>
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
                        <h4 class="modal-title">{{ trans('settings.modify') }}</h4>
                    </div>
                    <div class="modal-body">
                        <p>{{ trans('settings.delete_rec') }}</p>
                        {{--<p class="text-warning"><small>If you don't save, your changes will be lost.</small></p>--}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"> {{ trans('settings.close') }} </button>
                        <button type="button" class="btn btn-primary save" id="save_article"> {{ trans('settings.save_changes') }}</button>
                    </div>
                </div>
            </div>
        </div>


    </body>
    <footer>
        <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
        <!-- Latest compiled JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/locale/hy-am.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.js"></script>
        <script type="text/javascript">
            $(function () {

                $('#datetimepicker6').datetimepicker({
                    format: 'YYYY/MM/DD',
                    locale: $('#articles').attr('data-lang')
                });
                $('#datetimepicker7').datetimepicker({
                    useCurrent: false, //Important! See issue #1075
                    format: 'YYYY/MM/DD',
                    locale: $('#articles').attr('data-lang')
                });
                $("#datetimepicker6").on("dp.change", function (e) {
                    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function (e) {
                    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });
            });
            $('.selectpicker').selectpicker();

        </script>

        <script src="{{ URL::asset('js/article/article.js')}}"></script>
        <script>
            Article.prototype.dialog = function (title, description, main_image, data, url) {
                return '<div class="editform">' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="title">' +  '<?= trans("settings.title") ?>:' + '</label>\n' +
                    '    <textarea  class="form-control" id="title" rows="2" cols="2" >'+ title + '</textarea>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="description">' + '<?= trans("settings.desc") ?>:'  + '</label>\n' +
                    '    <textarea  class="form-control" id="description" rows="4" cols="4" >'+ description + '</textarea>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform row">\n' +
                    ' <div class="col-md-6">'+
                    '    <label for="main_image">' +  '<?= trans("settings.image") ?>:'   +'</label>\n' +
                    '    <img  id="main_image" src="' + main_image + '" width="180" height="120" />\n' +
                    ' </div>'+
                    ' <input type="file" id ="main_image_file" name="main_image_file" class="col-md-6"></input>\n'+
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="data">' + '<?= trans("settings.data") ?>:' + '</label>\n' +
                    '    <input  type="date" class="form-control" id="data" value='+ data +'>\n' +
                    '  </div>\n' +
                    ' <div class="form-group editform">\n' +
                    '    <label for="url">' + '<?= trans("settings.url") ?>:'  + '</label>\n' +
                    '    <input  class="form-control" id="url" value='+ url +'>\n' +
                    '  </div>\n' +
                    ' </div>';

            };
        </script>

    </footer>
</html>