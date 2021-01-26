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
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                    <h3 class="login-header">
                        Enter your MyCaseWare account or Azure credentials. An SDK developer license is required. 
                    </h3>
                    <form class="form-horizontal" method="POST" action="/mycwauth">
                        {{ csrf_field() }}

                        <div class="form-group{{ !$errors->isEmpty() ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ !$errors->isEmpty() ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors)
                                    @foreach ($errors->all() as $error)
                        
                                        <span class="help-block">
                                            <strong>{{ $error }}</strong>
                                        </span>                                
                                    @endforeach
                                @endif
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login with MyCaseWare
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="col-md-8 col-md-offset-4">
                        <a href="login/azure">
                            <button type="submit" class="btn btn-primary">
                                Employee Login
                            </button>
                        </a>
                    </div>
        </div>
    </div>
</div>

@endsection

