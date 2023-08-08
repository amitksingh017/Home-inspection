@extends('admin::layouts.app')

@section('title', 'Profile')

@section('content')

    <div class="card-container" style="width: 100%; display: inline-block; vertical-align: top;">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="kt-portlet kt-portlet--mobile" style="display: block; padding: 20px;">
                    <form method="POST" action="{{ route('users.store') }}">
                        {{ csrf_field() }}
                        <div class="field-row image-field js-validation">
                            <div class="kt-section">
                                <h5>Profile picture</h5>
                                <div class="file-image"  data-field="avatar">
                                    <div class="img-container" data-prefix="/vendor/admin/themes/{{ _ADMIN_THEME_ }}/img/files/">
                                        <img
                                             data-src="@if($user->avatar){{Storage::url($user->avatar)}}@else{{asset('img/no_avatar.png')}}@endif"
                                             src="@if($user->avatar){{Storage::url($user->avatar)}}@else{{asset('img/no_avatar.png')}}@endif"
                                             alt="Avatar"
                                        />
                                        <i class="far fa-trash-alt"></i>
                                    </div>
                                </div>
                            </div>
                            @if ($errors->has('avatar'))
                                <div class="invalid-feedback" style="display: block;">
                                    {{ $errors->first('avatar') }}
                                </div>
                            @endif
                        </div>
                        <div class="field-row">
                            <div class="kt-section">
                                <h5>First name</h5>
                                <div class="kt-section__content">
                                    <div class="input-group">
                                        <input type="text" readonly class="element_form form-control
                                @if ($errors->has('first_name')) is-invalid @endif" name="first_name" value="{{ old('first_name') ?? $user->first_name }}" />
                                    </div>
                                </div>
                                @error('first_name')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="kt-section">
                                <h5>Last name</h5>
                                <div class="kt-section__content">
                                    <div class="input-group">
                                        <input type="text" readonly class="element_form form-control
                                @if ($errors->has('last_name')) is-invalid @endif" name="last_name" value="{{ old('last_name') ?? $user->last_name }}" />
                                    </div>
                                </div>
                                @error('last_name')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="kt-notification__custom kt-space-between">
                            <a href="{{ route('users.edit') }}" class="btn btn-label btn-label-brand btn-sm btn-bold">Edit</a>
                        </div>
                        <a href="/" class="btn btn-brand btn-icon-sm btn-right">
                            <i class="flaticon2-back"></i> Back
                        </a>
                    </form>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6">
                <div class="kt-portlet kt-portlet--mobile" style="display: block; padding: 20px;">
                    <form method="POST" action="{{ route('change.password') }}">
                        {{ csrf_field() }}
                        <div class="field-row">
                            <div class="kt-section">
                                <h5>Email</h5>
                                <div class="kt-section__content">
                                    <div class="input-group">
                                        <input type="text" readonly class="element_form form-control
                                @if ($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') ?? $user->email }}" />
                                    </div>
                                </div>
                                @error('email')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
