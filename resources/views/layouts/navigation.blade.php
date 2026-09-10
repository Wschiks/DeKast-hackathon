<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

            </div>

            <!-- Logout -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gray-100 border border-transparent rounded-md font-semibold text-sm uppercase tracking-widest hover:bg-gray-200 focus:outline-none disabled:opacity-50">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
