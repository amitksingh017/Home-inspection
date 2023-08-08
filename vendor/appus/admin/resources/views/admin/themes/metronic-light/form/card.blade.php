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

            <form method="POST" action="{{ $url }}">

                {{ csrf_field() }}

                {{ method_field($method) }}

                <input type="hidden" name="hash" value="{{ $hash }}" />

                <input type="hidden" name="_action" value="{{ $action }}" />

                    @foreach ($fields as $field)
                        @if($field->isColumn())
                            {!! $field->render() !!}
                        @else
                            <div class="field-row">
                                {!! $field->render() !!}
                            </div>
                        @endif
                    @endforeach

                <div>
                    <button class="btn btn-success @if($ajax) save_form @endif ">Save</button>
                </div>
            </form>

        </div>
    @endif

    {!! $viewAppend !!}
</div>
