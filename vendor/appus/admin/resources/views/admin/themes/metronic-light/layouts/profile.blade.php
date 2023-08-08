<div class="kt-header__topbar">
    <div class="kt-header__topbar-item kt-header__topbar-item--user">
        <form method="post" action="{{ route('logout') }}">
            {{ csrf_field() }}
            <button href="/logout" class="btn btn-label btn-label-brand btn-sm btn-bold">
                Logout
            </button>
        </form>
    </div>
</div>
