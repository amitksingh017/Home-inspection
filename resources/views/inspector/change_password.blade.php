@extends('admin::layouts.app')

@section('title', 'Change Password')

@section('content')

    <div class="card-container" style="width: 100%; display: inline-block; vertical-align: top;">
        <div class="row">
            <div class="col-xl-6 col-lg-6">
                <div class="kt-portlet kt-portlet--mobile" style="display: block; padding: 20px;">
                    <form method="POST" action="{{ route('inspectors.change-password', $inspector->id) }}">
                        {{ csrf_field() }}
{{--                        {{dd($inspector->id)}}--}}
                        <div class="input-group">
                            <input class="form-control" type="hidden" name="inspectorId" value="{{ $inspector->id }}" autocomplete="off">
                        </div>
                        <div class="field-row">
                            <div class="kt-section">
                                <h5>Current password</h5>
                                <div class="kt-section__content">
                                    <div class="input-group">
                                        <input type="password" class="element_form form-control" name="current_password" value="" />
                                    </div>
                                </div>
                                @error('current_password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="kt-section">
                                <h5>New password</h5>
                                <div class="kt-section__content">
                                    <div class="input-group">
                                        <input type="password" class="element_form form-control" name="password" value="" />
                                    </div>
                                </div>
                                @error('password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="kt-section">
                                <h5>Confirm password</h5>
                                <div class="kt-section__content">
                                    <div class="input-group">
                                        <input type="password" class="element_form form-control" name="password_confirmation" value="" />
                                    </div>
                                </div>
                                @error('confirm_password')
                                <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-success">Change password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
