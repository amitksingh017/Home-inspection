@extends('admin::auth.layout')

@section('content')

    <div class="kt-login__signin">
        <div class="kt-login__head">
            <h3 class="kt-login__title">Sign In</h3>
        </div>
        <form class="kt-form" method="post" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
                @if ($errors->has('email'))
                    <div class="invalid-feedback" style="display: block;">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Password" name="password">
                @if ($errors->has('password'))
                    <div class="invalid-feedback" style="display: block;">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="row kt-login__extra">
                <div class="col">
                    <label class="kt-checkbox">
                        <input type="checkbox" name="remember"> Remember me
                        <span></span>
                    </label>
                </div>
                @if(config('admin.auth.forgot_password'))
                    <div class="col kt-align-right">
                        <a href="javascript:;" id="kt_login_forgot" class="kt-link kt-login__link">Forgot Password ?</a>
                    </div>
                @endif
            </div>
            <div class="kt-login__actions">
                <button id="kt_login_signin_submit" class="btn btn-pill kt-login__btn-primary">Sign In</button>
            </div>
        </form>
    </div>

    @if(config('admin.auth.register'))
        <div class="kt-login__signup">
            <div class="kt-login__head">
                <h3 class="kt-login__title">Sign Up</h3>
                <div class="kt-login__desc">Enter your details to create your account:</div>
            </div>
            <form class="kt-login__form kt-form" method="post" action="{{ route('register') }}">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Fullname" name="name" autocomplete="off">
                    @if ($errors->has('name'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('name') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <input class="form-control" type="password" placeholder="Password" name="password">
                    @if ($errors->has('password'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('password') }}</div>
                    @endif
                </div>
                <div class="input-group">
                    <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation">
                    @if ($errors->has('password_confirmation'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
                @if(config('admin.auth.terms_and_conditions_route'))
                    <div class="row kt-login__extra">
                        <div class="col kt-align-left">
                            <label class="kt-checkbox" for="agree">
                                I Agree the <a href="{{ route(config('admin.auth.terms_and_conditions_route')) }}" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                                <input type="checkbox" id="agree" name="agree" />
                                <span></span>
                            </label>
                            <span class="form-text text-muted"></span>
                        </div>
                        @if ($errors->has('agree'))
                            <div class="invalid-feedback" style="display: block;">{{ $errors->first('agree') }}</div>
                        @endif
                    </div>
                @endif
                <div class="kt-login__actions">
                    <button id="kt_login_signup_submit" class="btn btn-pill kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
                    <button id="kt_login_signup_cancel" class="btn btn-pill kt-login__btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    @endif

    @if(config('admin.auth.forgot_password'))
        <div class="kt-login__forgot">
            <div class="kt-login__head">
                <h3 class="kt-login__title">Forgotten Password ?</h3>
                <div class="kt-login__desc">Enter your email to reset your password:</div>
            </div>
            <form class="kt-form" method="post" action="{{ route('password.email') }}">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
                    @if ($errors->has('email'))
                        <div class="invalid-feedback" style="display: block;">{{ $errors->first('email') }}</div>
                    @endif
                </div>
                <div class="kt-login__actions">
                    <button id="kt_login_forgot_submit" class="btn btn-pill kt-login__btn-primary">Request</button>&nbsp;&nbsp;
                    <button id="kt_login_forgot_cancel" class="btn btn-pill kt-login__btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    @endif

    @if(config('admin.auth.register'))
        <div class="kt-login__account">
            <span class="kt-login__account-msg">
                Don't have an account yet ?
            </span>&nbsp;&nbsp;
            <a href="javascript:;" id="kt_login_signup" class="kt-link kt-link--light kt-login__account-link">Sign Up</a>
        </div>
    @endif

@endsection
