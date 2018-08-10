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


    {{--<a href="#delModal" role="button" class="btn btn-large btn-primary add add_button" data-toggle="modal">Add Article</a>--}}
@endsection
