<form method="POST" class="content_form" data-hash="{{ $hash }}">

    <input type="hidden" name="hash" value="{{ $hash }}" />

    <div class="kt-portlet__body">
        <div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
            <div class="row align-items-center card-subheader">

                @include('admin::table.search')

                @include('admin::table.filter')

            </div>
        </div>

        @include('admin::table.multi-actions')

    </div>
    <input type="hidden" name="itemPerPage" value="{{ $itemPerPage }}" />
</form>
