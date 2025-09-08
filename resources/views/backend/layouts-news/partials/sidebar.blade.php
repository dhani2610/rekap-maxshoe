<nav class="sidebar p-3">
    @php
        $usr = Auth::guard('admin')->user();
        if ($usr != null) {
            $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        }

    @endphp

    <h5>Maxshoe</h5>
    @if ($usr->can('order.rekap'))
        <a href="{{ route('order.data.rekap') }}" class="{{ request()->routeIs('order.data.rekap') ? 'active' : '' }}"><i
                class="bi bi-grid"></i> Rekap Order</a>
    @endif

    @if ($usr->can('order.data'))
        <a href="{{ route('order') }}" class="{{ request()->routeIs('order') ? 'active' : '' }}"><i class="bi bi-bag"></i>
            Data
            Order</a>
    @endif

    @if ($usr->can('statistik.view'))
        <a href="{{ route('statistik') }}" class="{{ request()->routeIs('statistik') ? 'active' : '' }}"><i
                class="bi bi-people"></i> Statistik</a>
    @endif

    @if ($usr->can('karyawan.view'))
        <a href="{{ route('karyawan') }}" class="{{ request()->routeIs('karyawan') ? 'active' : '' }}"><i
                class="bi bi-people"></i> Data Karyawan</a>
    @endif

    @if ($usr->can('komisi.view'))
        <a href="{{ route('komisi') }}" class="{{ request()->routeIs('komisi') ? 'active' : '' }}"><i
                class="bi bi-gear"></i> Komisi</a>
    @endif

    @if ($usr->can('produk.view'))
        <a href="{{ route('produk') }}" class="{{ request()->routeIs('produk') ? 'active' : '' }}"><i
                class="bi bi-gear"></i> Data Produk</a>
    @endif

    @if ($usr->can('admin.view'))
        <a href="{{ route('admin.admins.index') }}"
            class="{{ request()->routeIs('admin.admins.index') ? 'active' : '' }}"><i class="bi bi-people"></i> Data
            User</a>
    @endif
    <form id="admin-logout-form" action="{{ route('admin.logout.submit') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @if ($usr->can('role.view'))
        <a href="{{ route('admin.roles.index') }}"
            class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}"><i class="bi bi-gear"></i> Setting
            Role</a>
        <hr>
    @endif

    <a class="dropdown-item" href="javascript:void(0);"
        onclick="event.preventDefault();
                        document.getElementById('admin-logout-form').submit();">
        <i class="bx bx-power-off me-2"></i>
        <span class="align-middle">Log Out</span>
    </a>
</nav>
