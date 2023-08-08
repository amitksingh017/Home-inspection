<div class="kt-section js-validation">
    <h5>{{ $name }}</h5>
    <div class="kt-section__content">
        <div class="input-group">
            <input
                readonly
                type="text"
                data-name="{{ $validationName }}"
                class="datetimepicker element_form form-control @if ($errors->has($field)) is-invalid @endif"
                name="{{ $field }}"
                value="{{ old($validationName) ?? $value }}"
            />
        </div>
    </div>
    @if($help)
        <span class="form-text text-muted">{{ $help }}</span>
    @endif
    @if ($errors->has($validationName))
        <div class="invalid-feedback" style="display: block;">
            {{ $errors->first($validationName) }}
        </div>
    @endif
</div>

@if($isOnlyDate)
    @push('js')
        <script>
            $('.datetimepicker[name="' + {!! json_encode($field) !!} + '"]').datepicker({
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd'
            });
        </script>
    @endpush
@elseif($isOnlyTime)
    @push('js')
        <script>
            $('.datetimepicker[name="' + {!! json_encode($field) !!} + '"]').timepicker({
                todayHighlight: true,
                autoclose: true,
                format: 'hh:ii'
            });
        </script>
    @endpush
@else
    @push('js')
        <script>
            $('.datetimepicker[name="' + {!! json_encode($field) !!} + '"]').datetimepicker({
                todayHighlight: true,
                autoclose: true,
                format: 'yyyy-mm-dd hh:ii:ss'
            });
        </script>
    @endpush
@endif
