<div class="notifications">

</div>
@push('js')
    <script>
        notifications(<?= \Message::getMessages(true) ?>);
    </script>
@endpush
