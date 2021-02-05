@php
$noHeader = true;
@endphp

@extends('default')

@section('html')
    @include('partials.html', [
        'exclusiveTo' => isset($exclusiveTo) ? $exclusiveTo : false,
    ])
@stop

@section('meta')
    @include('partials.meta', [
        'canonical' => url('/'),
        'url' => url('/'),
        'title' => 'Page not found',
        'og_description' => 'Page not found',
        'canonical' => 'test canonical url',
        'doNotTranslate' => isset($doNotTranslate) ? $doNotTranslate : false
    ])
@stop

@section('content')
<div class="container">
    <div class="row">
        <div class="page-404 col-sm-12 text-center">
            <div class="page-404__header">
                You're already logged in!
            </div>
            <div class="page-404__back-home">
                Let's go back <a href="/">home</a>
            </div>
        </div>
    </div>
</div>
@stop