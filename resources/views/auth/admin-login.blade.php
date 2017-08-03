@extends('auth.layouts.main')

@section('content')
    <div class="content">
        <form class="admin-login-form" action="{{ url('/admin/login') }}" method="post">
            {!! csrf_field() !!}
            <h3 class="form-title">Admin Login Area</h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> Enter any username and password. </span>
            </div>


            <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">User Name</label>
                <div class="input-icon">
                    <i class="fa fa-user"></i>
                    <input class="form-control placeholder-no-fix"
                           type="text"
                           placeholder="Username"
                           value="{{ old('username') }}"
                           name="username" />
                @if ($errors->has('username'))
                    <span id="email-error" class="help-block">
                    {{ $errors->first('username') }}
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

        </form>

    </div>
@endsection
