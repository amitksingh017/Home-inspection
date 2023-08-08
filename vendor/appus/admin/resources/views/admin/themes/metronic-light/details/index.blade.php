@extends('admin::layouts.app')

@section('title', $title)

@section('content')

    @include('admin::details.card')

    @if(!empty($cards))
        @foreach ($cards as $card)
            {!! $card->render() !!}
        @endforeach
    @endif

@endsection

@include('admin::layouts.global-css-and-js')
