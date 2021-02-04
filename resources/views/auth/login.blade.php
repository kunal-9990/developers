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
                <p>Enter your MyCaseWare account or Azure credentials. An SDK developer license is required.</p>
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

                <div class="btn-group">
                    <button type="submit" class="btn btn--primary">
                        Login with MyCaseWare
                    </button>
                    <span>or</span>
                    <a href="login/azure">
                        <button type="submit" class="btn btn--secondary">
                            Employee Login
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

