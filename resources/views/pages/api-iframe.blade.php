@extends('default')

@section('html')
@include('partials.html', [
'exclusiveTo' => isset($exclusiveTo) ? $exclusiveTo : false,
])
@stop

@section('meta')
@include('partials.meta', [
'canonical' => URL::current(),
'url' => URL::current(),
'title' => isset($title) ? $title : false,
'og_description' => isset($title) ? $title : false,
'doNotTranslate' => isset($doNotTranslate) ? $doNotTranslate : false,
])
@stop

@section('content')
<div class="row">
    <div class="col-sm-12">
        <iframe src="http://mk2.iserv-staging.caseware.com/cloud/Content/Reference/{{$slug}}/API/index.html" style="overflow:hidden;height:1500px;width:100%" frameborder="0"></iframe>
    </div>
</div>


    {{-- back to top button --}}
    @include('partials.back-to-top')

    {{-- modal overlay for images in content --}}
    @include('partials.image-modal')

    {{-- modal overlay for email subscription and pdf download --}}
    @include('partials.download-pdf')
    @stop


