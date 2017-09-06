@extends('article.layouts.base')
@section('content')


    <table id="articles" class="table table-hover table-condensed" style="width:100%; padding-top:1%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Main Image</th>
            <th>Data</th>
            <th>Url</th>
            <th>Action</th>
        </tr>
        </thead>
    </table>


    <a href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal" class="btn btn-primary">Add Article</a>
@endsection
