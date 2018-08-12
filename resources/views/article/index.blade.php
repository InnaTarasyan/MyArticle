@extends('article.layouts.base')
@section('content')

    <div class="container" style="padding-bottom: 5%;">
        <div class='col-md-5'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker6' style="z-index: 1">
                    <input type='text' class="form-control" placeholder="{{ trans('settings.start_date') }}" data-toggle="tooltip" data-placement="bottom" title="{{ trans('settings.start_date_desc') }}"/>
                    <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                </div>
            </div>
        </div>
        <div class='col-md-5'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker7' style="z-index: 1">
                    <input type='text' class="form-control" placeholder="{{ trans('settings.end_date') }}" data-toggle="tooltip" data-placement="bottom" title="{{ trans('settings.end_date_desc') }}"/>
                    <span class="input-group-addon">
                       <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>
        <div>
            <button type="button" id="search_btn" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{ trans('settings.search') }}"> {{ trans('settings.search') }}...</button>
        </div>
        <div class='col-md-5'>
            <div style="padding-bottom: 5%; padding-top: 5%;">
                <div class="dropdown" data-toggle="tooltip" data-placement="bottom" title="{{ trans('settings.total_desc') }}">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" >
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

    <!-- The Modal -->
    <div id="myModal" class="modal myModal">
        <!-- The Close Button -->
        <span class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>

    <table id="articles" class="table table-hover table-condensed" style="width:100%;" data-lang="{{ Config::get('app.locale') }}">
        <thead>
        <tr>
            <th> {{ trans('settings.id') }} </th>
            <th> {{ trans('settings.title') }} </th>
            <th> {{ trans('settings.desc') }} </th>
            <th> {{ trans('settings.image') }} </th>
            <th> {{ trans('settings.data') }} </th>
            <th> {{ trans('settings.url') }} </th>
            <th> {{ trans('settings.action') }} </th>
            <th> {{ trans('settings.select') }} </th>
        </tr>
        </thead>
    </table>

    <div style="padding-bottom: 5%;">
        <a href="#delModal" role="button" class="btn btn-large btn-primary add add_button" data-toggle="modal" > {{ trans('settings.add_article') }}</a>
        <a href="#" role="button" class="btn btn-large btn-danger" data-toggle="modal" id="delete_all" > {{ trans('settings.delete_selected') }} </a>
    </div>

@endsection
