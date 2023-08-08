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
                    <a class="btn btn-success @if($ajax) save_form @endif ">Save</a>
                </div>
                <!-- basic modal -->
                <div class="modal fade" id="inspectorModal" tabindex="-1" role="dialog" aria-labelledby="inspectorModal" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <h4>Do you want to update the inspector data?</h4>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <div>
                                    <a class="btn btn-success @if($ajax) save_form @endif ">Save</a>
                                </div>
                                <div class="kt-notification__custom kt-space-between">
                                    <a href="#" class="btn btn-label btn-label-brand btn-sm btn-bold" data-toggle="modal" data-target="#inspectorModal">Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    @endif

    {!! $viewAppend !!}
</div>




