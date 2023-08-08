@if ($searchable)
    <div class="col-md-3 kt-margin-b-20-tablet-and-mobile" style="display: inline-block;">
        <div class="kt-input-icon kt-input-icon--left">
            <input type="text" class="form-control generalSearch" placeholder="Search..." name="search" value="{{ $search }}" >
            <span class="kt-input-icon__icon kt-input-icon__icon--left">
                <span><i class="la la-search"></i></span>
            </span>
        </div>
    </div>
@endif
