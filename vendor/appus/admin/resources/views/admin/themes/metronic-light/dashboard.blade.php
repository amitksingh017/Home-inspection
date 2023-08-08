@extends('admin::layouts.app')

@section('title', 'Dashboard')

@section('content')

    @include('admin::metrics.container')

    @if(empty($metrics))
        <div class="empty-dashboard-container">
            <div class="center">
                Dashboard is empty yet
            </div>
        </div>
    @endif

@endsection
