@extends('auth.layouts.main')

@section('content')
    <div class="content">
        <form class="register-form" action="{{ url('/register') }}" method="post" style="display: block">
            <h3>Sign Up</h3>
            {!! csrf_field() !!}
            <p> Enter your personal details below: </p>
            <div class="form-group {{ $errors->has('fullname') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                <div class="input-icon">
                    <i class="fa fa-font"></i>
                    <input class="form-control placeholder-no-fix" type="text" value="" placeholder="Full Name" name="fullname" />
                    @if ($errors->has('fullname'))
                        <span id="email-error" class="help-block">
                            {{ $errors->first('fullname') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                <label class="control-label visible-ie8 visible-ie9">Email</label>
                <div class="input-icon">
                    <i class="fa fa-envelope"></i>
                    <input class="form-control placeholder-no-fix" type="text" placeholder="Email" name="email" />
                    @if ($errors->has('email'))
                        <span id="email-error" class="help-block">
                            {{ $errors->first('email') }}
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Country</label>
                <select name="country_id" id="country_list" class="select2 form-control">

                    <option value=""></option>
                    @foreach($country as $key=>$each)
                        <option value="{{$key}}">{{$each}}</option>
                    @endforeach

                </select>

                @if ($errors->has('country_id'))
                    <span id="email-error" class="help-block">
                            {{ $errors->first('country_id') }}
                        </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('timezone') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Timezone</label>
                <select name="timezone" id="timezone_list" class="select2 form-control">

                    <option value=""></option>
                    @foreach($timezone as $key=>$each)
                        <option value="{{$key}}">{{$each}}</option>
                    @endforeach

                </select>

                @if ($errors->has('timezone'))
                    <span id="email-error" class="help-block">
                            {{ $errors->first('timezone') }}
                        </span>
                @endif
            </div>
            <p> Enter your account details below: </p>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <div class="input-icon">
                    <i class="fa fa-lock"></i>
                    <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" />

                    @if ($errors->has('password'))
                        <span id="email-error" class="help-block">
                            {{ $errors->first('password') }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                <div class="controls">
                    <div class="input-icon">
                        <i class="fa fa-check"></i>
                        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="tnc" /> I agree to the
                    <a href="javascript:;"> Terms of Service </a> and
                    <a href="javascript:;"> Privacy Policy </a>
                </label>
                <div id="register_tnc_error"> </div>
            </div>
            <div class="form-actions">
                <a type="button" href="/" id="back-btn" class="btn red btn-outline">Back </a>
                <button type="submit" id="register-submit-btn" class="btn green pull-right"> Sign Up </button>
            </div>
        </form>
        <!-- END REGISTRATION FORM -->
    </div>
@endsection
