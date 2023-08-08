@push('js')
    <script>
        $(document).ready(function () {
            getContent(<?=json_encode($hash) ?>);
        });
    </script>
@endpush
