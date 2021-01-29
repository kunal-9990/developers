@extends('default_layout')


@section('content')
<div class="colcontainer container">
    <div class="row">
        <div class="toccol col-xs-12 col-sm-pull-0 col-md-pull-0 col-lg-pull-0 col-xs-pull-3 hidden-xs col-lg-3 col-md-4 col-sm-4">
            <div id="toc" class="tocdiv pull-right tocborder">
            </div>
            <br />
        </div>
        <div id="topicvid" class="col-md-8 col-xs-12 col-sm-8 col-lg-9">
        </div>
        <div class="col-xs-12 maincontentarea col-lg-6 col-md-8 col-sm-8">
            {!!$maincontentarea!!}
        </div>
        <div class="rightcol col-md-8 col-lg-3 col-md-pull-0 col-lg-pull-0 col-lg-push-0 col-sm-8 pull-right col-xs-12">


            <div id="videocontainer" class="rightcolitem">
            </div>
            <p id="vidtitle" class="vidtitle">
            </p>
            <div id="workflows">
            </div>
            <ul id="recentpages" class="recentlyviewedlist">
            </ul>
            <div class="rightcolitem" id="feedbackbox">
                <p id="feedbackmessage" class="rightcoltitle">Was this topic helpful?<br /></p>
                <button type="button" class="btn btn-default feedbackbutton" onclick="feedback('Yes')">Yes</button>
                <button type="button" class="btn btn-default feedbackbutton" onclick="feedback('No')">No</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../scripts/clipboard.min.js"></script>
@stop

