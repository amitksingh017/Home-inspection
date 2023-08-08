<div class="column-row" style="width: {{ $width ?? 100 }}%;">
    @if(!empty($fields))

        @foreach ($fields as $field)
            <div class="field-row">
                {!! $field->render() !!}
            </div>
        @endforeach

    @endif
</div>