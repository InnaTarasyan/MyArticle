@extends('article.layouts.base')
@section('css')
    <style>
        .span4 img {
            margin-right: 10px;
        }
        .span4 .img-left {
            float: left;
        }
    </style>
@endsection
@section('content')
    <div id="contactUs" >
        <div class="container">
            <div class="row">
                <h2 style="text-align: center">{{ trans('settings.site_description') }}</h2>
            </div>

            <div class="block">
                <div class="row">
                    <div class="span4">
                        <img class="img-left" src="{{ asset('inna_photo.jpg') }}" style="width: 15%"/>
                        {!! trans('settings.about_inna') !!}
                        {!! trans('settings.about_site') !!}
                    </div>
                </div>
                <br/>
            </div>

        </div>
        <div class="container">
            <div class="row text-center" style="padding-top: 8%;">
                <div class="site-title text-center ">
                    <h3> {{ trans('settings.contact') }}</h3>
                </div>
                <br/> <br/>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <div id="map" style="width:100%;height:20em;background:yellow"></div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12" >
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action= {{route('about','#contactUs')}} method="post">
                        {{csrf_field()}}
                        <div class="m-demo__preview">
                            <div class="form-group m-form__group {{ $errors->has('name') ? 'has-error' : '' }}">
                                <input  class="form-control m-input m-input--square input-lg"  name="name" placeholder="{{ trans('settings.username') }}">
                                <span style="color: red;"> {!! $errors->first('name') !!} </span>
                            </div>

                            <div class="form-group m-form__group {{ $errors->has('email') ? 'has-error' : '' }}">
                                <input type="text" class="form-control m-input input-lg" placeholder="{{ trans('settings.email') }}" name="email">
                                <span style="color: red;"> {!! $errors->first('email') !!} </span>
                            </div>

                            <div class="form-group m-form__group row {{ $errors->has('text') ? 'has-error' : '' }}">
                                <div class="col-lg-12">
                                    <textarea name="text" class="form-control"  rows="15" placeholder="{{ trans('settings.message') }}" id="editor"></textarea>
                                    <span style="color: red;"> {!! $errors->first('text') !!} </span>
                                </div>
                            </div>

                            <button type="submit" class="btn m-btn--pill  btn-primary">
                                {{ trans('settings.submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <hr>
        <br><br>
    </div>
@endsection


