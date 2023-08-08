<div class="card-container" style="width: {{ $width ?? 100  }}%; display: inline-block; vertical-align: top;">

    @include('admin::metrics.container')

    {!! $viewPrepend !!}

    @if($body && !empty($columns))

        <div class="kt-portlet kt-portlet--mobile card">

            @include('admin::table.header')

            @include('admin::table.subheader')

            <div class="kt-portlet__body kt-portlet__body--fit">
                <!--begin: Datatable -->
                <div class="kt-datatable kt-datatable--default kt-datatable--brand kt-datatable--loaded content_body" id="local_data">
                    @if(empty($data))
                        @include('admin::table.load')
                    @else
                        @include('admin::table.list')
                    @endif
                </div>
                <!--end: Datatable -->
            </div>

        </div>
    @endif

    {!! $viewAppend !!}

</div>



