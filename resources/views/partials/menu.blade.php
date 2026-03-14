<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">

            {{-- ═══ الرئيسية ═══ --}}
            <li class="nav-item">
                <a href="{{ route('admin.home') }}"
                   class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-fw fa-tachometer-alt"></i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>

            {{-- ═══ الحجوزات (قائمة + تقويم) ═══ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/bookings*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-calendar-check"></i>
                    {{ trans('global.menu.group_bookings') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.bookings.index') }}"
                           class="nav-link {{ request()->is('admin/bookings*') && !request()->routeIs('admin.bookings.calendar') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-list nav-icon"></i>
                            {{ trans('global.menu.bookings_list') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.bookings.calendar') }}"
                           class="nav-link {{ request()->routeIs('admin.bookings.calendar') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-calendar-alt nav-icon"></i>
                            {{ trans('global.menu.calendar') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══ الباقات ═══ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/ad-packages*') || request()->is('admin/event-packages*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-box-open"></i>
                    {{ trans('global.menu.group_packages') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.ad-packages.index') }}"
                           class="nav-link {{ request()->is('admin/ad-packages*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-bullhorn nav-icon"></i>
                            {{ trans('global.menu.ad_packages') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.event-packages.index') }}"
                           class="nav-link {{ request()->is('admin/event-packages*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-gift nav-icon"></i>
                            {{ trans('global.menu.event_packages') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══ المحتوى (بورتفوليو، FAQ، آراء) ═══ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/portfolio-items*') || request()->is('admin/faqs*') || request()->is('admin/testimonials*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-images"></i>
                    {{ trans('global.menu.group_content') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.portfolio-items.index') }}"
                           class="nav-link {{ request()->is('admin/portfolio-items*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-th-large nav-icon"></i>
                            {{ trans('global.menu.portfolio') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.faqs.index') }}"
                           class="nav-link {{ request()->is('admin/faqs*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-question-circle nav-icon"></i>
                            {{ trans('global.menu.faq') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.testimonials.index') }}"
                           class="nav-link {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-comments nav-icon"></i>
                            {{ trans('global.menu.testimonials') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══ العملاء والرسائل ═══ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/clients*') || request()->is('admin/client-messages*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-users"></i>
                    {{ trans('global.menu.group_clients') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.clients.index') }}"
                           class="nav-link {{ request()->is('admin/clients*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user-friends nav-icon"></i>
                            {{ trans('global.menu.clients') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.client-messages.index') }}"
                           class="nav-link {{ request()->is('admin/client-messages*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-envelope nav-icon"></i>
                            {{ trans('global.menu.client_messages') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══ الإعدادات (موظفون، قاعات، شركة) ═══ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/employees*') || request()->is('admin/eventlocations*') || request()->is('admin/company*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-cogs"></i>
                    {{ trans('global.menu.group_settings') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.employees.index') }}"
                           class="nav-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-user-tie nav-icon"></i>
                            {{ trans('global.menu.employees') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.eventlocations.index') }}"
                           class="nav-link {{ request()->is('admin/eventlocations*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-map-marker-alt nav-icon"></i>
                            {{ trans('global.menu.event_locations') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.company') }}"
                           class="nav-link {{ request()->routeIs('admin.company') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-building nav-icon"></i>
                            {{ trans('global.menu.company') }}
                        </a>
                    </li>
                </ul>
            </li>

            {{-- ═══ المستخدمون والصلاحيات ═══ --}}
            <li class="nav-item nav-dropdown {{ request()->is('admin/permissions*') || request()->is('admin/roles*') || request()->is('admin/users*') ? 'open' : '' }}">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon fas fa-users-cog"></i>
                    {{ trans('global.menu.group_system') }}
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

            {{-- ═══ تسجيل الخروج ═══ --}}
            <li class="nav-item">
                <a href="#" class="nav-link"
                   onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fas fa-fw fa-sign-out-alt"></i>
                    {{ trans('global.menu.logout') }}
                </a>
            </li>

        </ul>
    </nav>

    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
