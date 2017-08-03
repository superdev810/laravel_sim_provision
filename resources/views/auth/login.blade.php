@extends('auth.layouts.main')

@section('content')
    <div class="content">
        <form class="login-form" action="{{ url('/login') }}" method="post">
            {!! csrf_field() !!}
            <h3 class="form-title">Login to your account</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter any email and password. </span>
            </div>


            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <div class="input-icon">
                    <i class="fa fa-envelope"></i>
                    <input class="form-control placeholder-no-fix"
                           type="text"
                           placeholder="Email"
                           value="{{ old('email') }}"
                           name="email" />
                @if ($errors->has('email'))
                    <span id="email-error" class="help-block">
                    {{ $errors->first('email') }}
                </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
                    @if ($errors->has('password'))
                        <span id="password-error" class="help-block">
                        {{ $errors->first('password') }}
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-actions">
                <label class="checkbox">
                    <input type="checkbox" name="remember" value="1" /> Remember me </label>
                <button type="submit" class="btn green pull-right"> Login </button>
            </div>

{{--            <div class="forget-password">
                <h4>Forgot your password ?</h4>
                <p> no worries, click
                    <a href="{{url('/password/reset')}}" id="forget-password"> here </a> to reset your password. </p>
            </div>--}}
        </form>

    </div>
@endsection
