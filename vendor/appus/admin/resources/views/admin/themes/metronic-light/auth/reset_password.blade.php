@extends('admin::auth.layout')

@section('content')

    <div class="kt-reset_password">
        <div class="kt-login__head">
            <h3 class="kt-login__title">Reset Password</h3>
        </div>
        <form class="kt-form" method="post" action="{{ route('reset_password') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}" />
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Email" name="email" value="{{ $email }}" autocomplete="off">
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
            <div class="kt-login__actions">
                <button id="kt_reset_password_submit" class="btn btn-pill kt-login__btn-primary">Reset</button>
            </div>
        </form>
    </div>

@endsection
