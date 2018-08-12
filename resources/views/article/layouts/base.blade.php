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

        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/"> {{ trans('settings.site_name') }}</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/"> {{ trans('settings.home') }} </a></li>
                    <li><a href="{{ route('about') }}"> {{ trans('settings.about') }} </a></li>
                </ul>
            </div>
        </nav>

        <div style="text-align: right; padding-right: 1%;padding-top: 1%;">
            <select class="selectpicker" onchange="myFunction()" data-width="fit"  id="langs" name="langs"  >
                <option data-content='<span class=""></span> {{ trans('settings.select_language') }}'>" select</option>
                <option data-content='<span  class="flag-icon flag-icon-am"></span> Armenian' data-href="{{ URL::to('setlocale/am') }}" >am</option>
                <option data-content='<span  class="flag-icon flag-icon-us"></span> English' data-href="{{ URL::to('setlocale/en')}}">en</option>
            </select>
        </div>

        <div class="container" style="padding-top:2%">
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
        <script src="{{ asset('js/bootstrap-tooltip.js') }}"></script>
        <script type="text/javascript">
            $(function () {
                $("body").tooltip({ selector: '[data-toggle=tooltip]' });
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
        <script>
            function myMap() {
                var myCenter = new google.maps.LatLng(40.182344, 44.513337);
                var mapCanvas = document.getElementById("map");
                var mapOptions = {center: myCenter, zoom: 5};
                var map = new google.maps.Map(mapCanvas, mapOptions);
                var marker = new google.maps.Marker({position:myCenter});
                marker.setMap(map);
            }
        </script>
        @if(isset($key))
           <script src="https://maps.googleapis.com/maps/api/js?key={{$key}}&language={{  App::getLocale() == 'en' ? 'en' : 'hy'}}&callback=myMap"></script>
        @endif
    </footer>
</html>