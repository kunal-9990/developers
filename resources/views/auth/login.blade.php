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
<div class="container login">
    <div class="row">
        <div class="col-xs-12 col-sm-8">
            <div class="intro">
                <h1>Log in</h1>
                <hr/>
                <p class="grey-font">Enter your MyCaseWare account or Azure credentials.<br class="hide-br"/>&nbsp;An SDK developer license is required.</p>
            </div>
            <form class="form-horizontal" method="POST" action="/mycwauth">
                {{ csrf_field() }}
                <div class="form-group{{ !$errors->isEmpty() ? ' has-error' : '' }}">
                    <input 
                        id="email"
                        type="email" 
                        class="form-control" 
                        name="email" 
                        value="{{ old('email') }}" 
                        placeholder="Email"
                        required 
                        autofocus
                    >
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group{{ !$errors->isEmpty() ? ' has-error' : '' }}">
                    <input 
                        id="password" 
                        type="password" 
                        class="form-control" 
                        name="password" 
                        placeholder="Password"
                        required
                    >
                    @if ($errors)
                        @foreach ($errors->all() as $error)
                            <span class="help-block">
                                <strong>{{ $error }}</strong>
                            </span>                                
                        @endforeach
                    @endif
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn--primary">
                        Login with MyCaseWare
                    </button>
                </div>
            </form>
            <div class="button-group button-group--2">
                <div class="separator"><span class="grey-font">OR</span></div>
                <a href="login/azure">
                    <button class="btn btn--secondary">
                        CaseWare SSO
                    </button>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

