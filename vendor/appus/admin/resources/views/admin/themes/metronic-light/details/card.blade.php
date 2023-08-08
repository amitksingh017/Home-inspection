<div class="card-container" style="width: {{ $width ?? 100  }}%; display: inline-block; vertical-align: top;">

    @include('admin::metrics.container')

    {!! $viewPrepend !!}

    @if($body && !empty($fields))
        <div class="kt-portlet kt-portlet--mobile" style="display: block; padding: 20px;">

            @if(!empty($title))
                <div class="card-title">
                    {{ $title }}
                </div>
            @endif

            @foreach ($fields as $field)
                @if($field->isColumn())
                    {!! $field->render() !!}
                @else
                    <div class="field-row">
                        {!! $field->render() !!}
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    {!! $viewAppend !!}

</div>
