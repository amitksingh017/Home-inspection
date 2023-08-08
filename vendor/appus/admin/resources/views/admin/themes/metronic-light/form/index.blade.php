@extends('admin::layouts.app')

@section('title', $title)

@section('content')

    @include('admin::form.card')

    @if(!empty($cards))
        @foreach ($cards as $card)
            {!! $card->render() !!}
        @endforeach
    @endif

@endsection

@include('admin::layouts.global-css-and-js')
