<style>

    .active-title {
        color: #white !important;
    }


    .menu-inner {
        background: #0a53be;
    } 
    .menu-vertical .menu-item .menu-link {
        color: white    
    }
</style>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme"
    style="    border-right: 3px solid rgb(114 113 113 / 52%);">
    <div class="app-brand demo ">
        <a href="#" class="app-brand-link">
            {{-- <span class="app-brand-logo demo">

      </span> --}}
            <img src="{{ asset('assets/img/logos/logo.png') }}" style="max-width: 40%">
            <span class=" demo fw-bold ms-2" style="color: white">Dashboard</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>
    @php
        $usr = Auth::guard('admin')->user();
        if ($usr != null) {
            $userRole = Auth::guard('admin')->user()->getRoleNames()->first(); // Get the first role name
        }

    @endphp

    <div class="menu-inner-shadow" style="background: #0a53be!Important"></div>

    <ul class="menu-inner py-1">
            @if ($usr->can('admin.view') || $usr->can('role.view'))
                <li
                    class="menu-item {{ Request::routeIs('admin/admins') || Request::routeIs('admin/roles') ? 'open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-layout"></i>
                        <div data-i18n="Layouts">Management Users</div>
                    </a>

                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::routeIs('admin/admins') ? 'active' : '' }}">
                            <a href="{{ route('admin.admins.index') }}" class="menu-link">
                                <div data-i18n="Without menu"
                                    style="color : {{ Request::routeIs('admin/admins') ? '#0a53be' : '' }}">Users
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif

    </ul>
</aside>
