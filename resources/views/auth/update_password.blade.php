@extends('admin::auth.layout')

@section('content')

    <div class="kt-reset_password">
        <div class="kt-login__head">
            <h3 class="kt-login__title">Reset Password</h3>
        </div>
        <form class="kt-form" method="post" action="{{route('save.password')}}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}" />
            <div class="input-group">
                <input class="form-control" type="hidden" placeholder="Email" name="email" value="{{ request()->get('email') }}" autocomplete="off">
            </div>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Password" name="password">
            </div>
            <div class="input-group">
                <input class="form-control" type="password" placeholder="Confirm Password" name="password_confirmation">
            </div>
            <div class="kt-login__actions">
                <a href="{{route('save.password')}}" id="kt_reset_password_submit" class="btn btn-pill kt-login__btn-primary">Reset</a>
            </div>
        </form>
    </div>

@endsection