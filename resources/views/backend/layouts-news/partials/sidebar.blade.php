<nav class="sidebar p-3">
    <h5>Maxshoe</h5>
    <a href="{{ route('order.data.rekap') }}" class="{{ request()->routeIs('order.data.rekap') ? 'active' : '' }}"><i
            class="bi bi-grid"></i> Rekap Order</a>
    <a href="{{ route('order') }}" class="{{ request()->routeIs('order') ? 'active' : '' }}"><i class="bi bi-bag"></i> Data
        Order</a>
    <a href="{{ route('statistik') }}" class="{{ request()->routeIs('statistik') ? 'active' : '' }}"><i
            class="bi bi-people"></i> Statistik</a>
    <a href="{{ route('karyawan') }}" class="{{ request()->routeIs('karyawan') ? 'active' : '' }}"><i
            class="bi bi-people"></i> Data Karyawan</a>
    <a href="{{ route('komisi') }}" class="{{ request()->routeIs('komisi') ? 'active' : '' }}"><i
            class="bi bi-gear"></i> Komisi</a>
    <a href="{{ route('produk') }}" class="{{ request()->routeIs('produk') ? 'active' : '' }}"><i
            class="bi bi-gear"></i> Data Produk</a>
    <a href="{{ route('admin.admins.index') }}"
        class="{{ request()->routeIs('admin.admins.index') ? 'active' : '' }}"><i class="bi bi-people"></i> Data
        User</a>
    <form id="admin-logout-form" action="{{ route('admin.logout.submit') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}"><i
            class="bi bi-gear"></i> Setting Role</a>
    <hr>
    <a class="dropdown-item" href="javascript:void(0);"
        onclick="event.preventDefault();
                        document.getElementById('admin-logout-form').submit();">
        <i class="bx bx-power-off me-2"></i>
        <span class="align-middle">Log Out</span>
    </a>
</nav>
