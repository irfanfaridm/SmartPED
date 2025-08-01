<nav x-data="{ open: false }" class="navbar-telkom border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('images.png') }}" alt="Telkom Logo" class="h-10 w-auto mr-3 rounded-full" />
                        <span class="text-white font-bold text-lg">Smart PED</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('hem.index')" :active="request()->routeIs('hem.*')">
                        HEM
                    </x-nav-link>
                    <x-nav-link :href="route('qe.index')" :active="request()->routeIs('qe.*')">
                        QE
                    </x-nav-link>
                    <x-nav-link :href="route('indihome.index')" :active="request()->routeIs('indihome.*')">
                        INDIHOME
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Timezone Display -->
                <div class="flex items-center mr-4">
                    <div id="current-time" class="text-white text-sm mr-2">{{ now()->format('H:i') }}</div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white bg-opacity-20 text-white">
                        WIB
                    </span>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-white hover:text-white hover:border-gray-300 focus:outline-none focus:text-white focus:border-gray-300 transition duration-150 ease-in-out">
                            <!-- User Avatar (Outside Box) -->
                            <div class="mr-2 -ml-1 relative z-10">
                                @if(Auth::user()->avatar)
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border-2 border-white shadow-sm">
                                @else
                                    <div class="h-9 w-9 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center border-2 border-white shadow-sm">
                                        <span class="text-white text-xs font-bold">{{ Auth::user()->initials }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex items-center bg-red-800 rounded-lg px-3 py-1 -ml-4 pl-5 shadow-md">
                                <div class="text-white">{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-white h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.show')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('hem.index')" :active="request()->routeIs('hem.*')">
                HEM
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('qe.index')" :active="request()->routeIs('qe.*')">
                QE
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('indihome.index')" :active="request()->routeIs('indihome.*')">
                INDIHOME
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <!-- Mobile Time Display -->
            <div class="px-4 mb-3 flex items-center justify-center">
                <div class="flex items-center">
                    <div id="mobile-current-time" class="text-white text-sm mr-2">{{ now()->format('H:i') }}</div>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-white bg-opacity-20 text-white">
                        WIB
                    </span>
                </div>
            </div>
            <div class="px-4 flex items-center">
                <!-- User Avatar (Mobile - Outside Box) -->
                <div class="mr-3 -ml-1 relative z-10">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm">
                    @else
                        <div class="h-12 w-12 rounded-full bg-gradient-to-r from-red-500 to-red-600 flex items-center justify-center border-2 border-white shadow-sm">
                            <span class="text-white text-sm font-bold">{{ Auth::user()->initials }}</span>
                        </div>
                    @endif
                </div>
                <div class="bg-red-800 rounded-lg px-3 py-2 -ml-6 pl-8 shadow-md">
                    <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-white text-opacity-80">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
// Auto-updating time function
function updateTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const timeString = `${hours}:${minutes}`;
    
    // Update desktop time
    const timeElement = document.getElementById('current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
    
    // Update mobile time
    const mobileTimeElement = document.getElementById('mobile-current-time');
    if (mobileTimeElement) {
        mobileTimeElement.textContent = timeString;
    }
}

// Update time immediately and then every second
updateTime();
setInterval(updateTime, 1000);
</script>
