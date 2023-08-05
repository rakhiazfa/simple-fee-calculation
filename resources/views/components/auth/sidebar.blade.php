<aside class="sidebar">
    <div class="sidebar-container">
        <a class="sidebar-header border-b" href="#">
            <div class="flex items-center gap-x-3 px-5">
                <div class="w-[40px] lg:w-[45px] aspect-square bg-gray-300 rounded-full">
                    <img class="rounded-full" src="{{ $user->avatar ? url('storage/' . $user->avatar) : $defaultAvatar }}"
                        alt="Avatar">
                </div>
                <div>
                    <p class="text-xs lg:text-sm font-medium max-w-[175px] overflow-hidden whitespace-nowrap mb-1">
                        {{ $user->name ?? '' }}
                    </p>
                    <p
                        class="text-[0.65rem] lg:text-[0.7rem] text-gray-400 font-normal max-w-[175px] overflow-hidden whitespace-nowrap">
                        {{ $user->email ?? '' }}
                    </p>
                </div>
            </div>
        </a>
        <nav class="menu-wrapper">
            <ul class="sidebar-menu">

                <li class="menu-title">Navigations</li>

                <li>
                    <a class="sidebar-link {{ request()->routeIs('dashboard*') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="uil uil-apps"></i>
                        <span> Dashboard </span>
                    </a>
                </li>

                <li>
                    <a class="sidebar-link {{ request()->routeIs('presences*') ? 'active' : '' }}"
                        href="{{ route('presences.index') }}">
                        <i class="uil uil-calendar-alt"></i>
                        <span> Kehadiran </span>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
