@if($metrics)
    <div class="metrics">
        @foreach($metrics as $metric)
            {!! $metric->render() !!}
        @endforeach
    </div>
@endif
