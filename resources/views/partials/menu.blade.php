<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('country_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.countries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-globe c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.country.title') }}
                </a>
            </li>
        @endcan
        @can('level_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.levels.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/levels") || request()->is("admin/levels/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-level-up-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.level.title') }}
                </a>
            </li>
        @endcan
        @can('universite_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.universites.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/universites") || request()->is("admin/universites/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.universite.title') }}
                </a>
            </li>
        @endcan
        @can('course_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.courses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/courses") || request()->is("admin/courses/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-book-open c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.course.title') }}
                </a>
            </li>
        @endcan
        @can('tutors_course_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.tutors-courses.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/tutors-courses") || request()->is("admin/tutors-courses/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-app-store c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.tutorsCourse.title') }}
                </a>
            </li>
        @endcan
        @can('price_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.prices.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/prices") || request()->is("admin/prices/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-money-bill-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.price.title') }}
                </a>
            </li>
        @endcan
        @can('wallet_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.wallets.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/wallets") || request()->is("admin/wallets/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-wallet c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.wallet.title') }}
                </a>
            </li>
        @endcan
        @can('review_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.reviews.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/reviews") || request()->is("admin/reviews/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-rev c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.review.title') }}
                </a>
            </li>
        @endcan
        @can('vaforite_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.vaforites.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/vaforites") || request()->is("admin/vaforites/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-vuejs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.vaforite.title') }}
                </a>
            </li>
        @endcan
        @can('conversation_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.conversations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/conversations") || request()->is("admin/conversations/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-comment-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.conversation.title') }}
                </a>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.settings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/settings") || request()->is("admin/settings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-sliders-h c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
            </li>
        @endcan
        @can('help_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.helps.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/helps") || request()->is("admin/helps/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-hire-a-helper c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.help.title') }}
                </a>
            </li>
        @endcan
        @can('booking_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.bookings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bookings") || request()->is("admin/bookings/*") ? "c-active" : "" }}">
                    <i class="fa-fw fab fa-first-order-alt c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.booking.title') }}
                </a>
            </li>
        @endcan
        @can('devicetoken_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.devicetokens.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/devicetokens") || request()->is("admin/devicetokens/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-fingerprint c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.devicetoken.title') }}
                </a>
            </li>
        @endcan
        @can('notification_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.notifications.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/notifications") || request()->is("admin/notifications/*") ? "c-active" : "" }}">
                    <i class="fa-fw far fa-bell c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.notification.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>