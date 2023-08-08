@if(!empty($css))
    @push('css')
         @foreach($css as $row)
             <link href="{{ $row }}" rel="stylesheet" />
         @endforeach
    @endpush
@endif

@if(!empty($js))
    @push('js')
        @foreach($js as $row)
            <script src="{{ $row }}"></script>
        @endforeach
    @endpush
@endif
