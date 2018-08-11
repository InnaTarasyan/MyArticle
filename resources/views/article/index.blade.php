@extends('article.layouts.base')
@section('content')

    <!-- The Modal -->
    <div id="myModal" class="modal myModal">
        <!-- The Close Button -->
        <span class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>

    <table id="articles" class="table table-hover table-condensed" style="width:100%; padding-top:1%">
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

    <a href="#delModal" role="button" class="btn btn-large btn-primary add add_button" data-toggle="modal" > {{ trans('settings.add_article') }}</a>
    <a href="#" role="button" class="btn btn-large btn-danger" data-toggle="modal" id="delete_all" > {{ trans('settings.delete_selected') }} </a>

@endsection
