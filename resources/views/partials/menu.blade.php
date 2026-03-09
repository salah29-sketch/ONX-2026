<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            {{-- ═══════════════════════════════════════
                 الرئيسية
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.home') }}"
                   class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt"></i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 الحجوزات
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.bookings.index') }}"
                   class="nav-link {{ request()->is('admin/bookings') || request()->is('admin/bookings/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    Réservations
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.bookings.calendar') }}"
                   class="nav-link {{ request()->routeIs('admin.bookings.calendar') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-calendar-alt"></i>
                    Calendrier
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 الباقات
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.ad-packages.index') }}"
                   class="nav-link {{ request()->is('admin/ad-packages*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-bullhorn nav-icon"></i>
                    Packs Pubs
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.event-packages.index') }}"
                   class="nav-link {{ request()->is('admin/event-packages*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-box-open nav-icon"></i>
                    Packs Mariages
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 البورتفوليو
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.portfolio-items.index') }}"
                   class="nav-link {{ request()->is('admin/portfolio-items*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-images"></i>
                    Portfolio
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 الشركة
            ═══════════════════════════════════════ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/company*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs nav-icon"></i>
                    {{ trans('global.company') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.company') }}"
                           class="nav-link {{ request()->routeIs('admin.company') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-info nav-icon"></i>
                            {{ trans('global.information') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══════════════════════════════════════
                 الموظفون
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.employees.index') }}"
                   class="nav-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-user-tie nav-icon"></i>
                    {{ trans('cruds.employee.title') }}
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 قاعات الأفراح
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.eventlocations.index') }}"
                   class="nav-link {{ request()->is('admin/eventlocations*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-map-marker-alt nav-icon"></i>
                    Salle des fêtes
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 العملاء
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="{{ route('admin.clients.index') }}"
                   class="nav-link {{ request()->is('admin/clients*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-users nav-icon"></i>
                    {{ trans('cruds.client.title') }}
                </a>
            </li>

            {{-- ═══════════════════════════════════════
                 إدارة المستخدمين والصلاحيات
            ═══════════════════════════════════════ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users-cog nav-icon"></i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.permissions.index') }}"
                           class="nav-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-unlock-alt nav-icon"></i>
                            {{ trans('cruds.permission.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}"
                           class="nav-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-briefcase nav-icon"></i>
                            {{ trans('cruds.role.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                           class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user nav-icon"></i>
                            {{ trans('cruds.user.title') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══════════════════════════════════════
                 تسجيل الخروج
            ═══════════════════════════════════════ --}}
            <li class="nav-item">
                <a href="#" class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>
                    {{ trans('global.logout') }}
                </a>
            </li>

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>