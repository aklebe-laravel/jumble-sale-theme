@php

    use Illuminate\Support\Facades\Auth;
    use Modules\Acl\app\Models\AclResource;
    use Modules\Acl\app\Services\UserService;

    /** @var UserService $userService */
    $userService = app(UserService::class);

    $navigation = app('website_base_settings')->getNavigation();

$testUsers = [];
if ($userService->hasUserResource(Auth::user(), AclResource::RES_TESTER)) {
    $testUsers = app(\App\Models\User::class)::with(['aclGroups.aclResources'])
    ->whereHas('aclGroups.aclResources', function ($query) {
        return $query->where('code', '=', AclResource::RES_NON_HUMAN);
    })
    ->whereHas('aclGroups.aclResources', function ($query) {
        return $query->where('code', '=', AclResource::RES_TRADER);
    })
    ->whereDoesntHave('aclGroups.aclResources', function ($query) {
        return $query->where('code', '=', AclResource::RES_ADMIN);
    })
    ->orderBy('last_visited_at', 'ASC')->limit(5)->get();
}

@endphp
<nav class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="main-nav-bar max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <nav class="navbar navbar-expand-lg navbar-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-auto-close="outside" data-bs-target="#navbarHeaderMain"
                                aria-controls="navbarHeaderMain"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarHeaderMain">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                @foreach($navigation->children as $navItem)
                                    @include('inc.nav-L1')
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </nav>

            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <form action="{{ route('search') }}" method="post">
                    @csrf
                    <span class="d-flex mr-2">
                    <input class="form-control" type="search" name="search" placeholder="{{ __('Search') }}"
                           aria-label="{{ __('Search') }}">
                    <button class="btn btn-outline-secondary" type="submit"><span class="bi bi-search"></span></button>
                </span>
                </form>
                {{-- @TODO: Remove breeze navigation --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div class="text-nowrap">
                                <span class="bi bi-person-circle"></span> {{ (Auth::check()) ? Auth::user()->name : __('Not logged in') }}
                                <br>
                                @if((Auth::check()))

                                    @if (app('market_settings')->canShowUserRating())
                                        <span class="small"
                                              x-data="{ratingContainer:{rating5:{{ Auth::user()->rating5 }}, show_value: false}}">
                                            @include('form::components.alpine.rating')
                                        </span>
                                    @endif
                                @endif
                            </div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        @if (Auth::check())
                            <x-dropdown-link :href="route('user-profile')" class="text-success">
                                {{ __('User Profile') }}
                            </x-dropdown-link>
                            @foreach($testUsers as $testUser)
                                <x-dropdown-link :href="route('user.claim', $testUser->shared_id)"
                                                 class="text-danger-emphasis">
                                    {{ __('Login: :name', ['name' => $testUser->name]) }}
                                </x-dropdown-link>
                            @endforeach
                            <x-dropdown-link :href="route('logout')" class="text-danger">
                                {{ __('Logout') }}
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('login')" class="text-danger">
                                {{ __('Login') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>
                <a class="text-nowrap mini-cart nav-link ml-2 position-relative" href="{{ route('shopping-cart') }}">
                    <span class="bi bi-cart"></span> {{ __('Shopping Cart') }}
                    <span class="position-absolute top-100 start-100 translate-middle badge rounded-pill"
                          :class="(cart.isLoaded) ? ((cart.object.qty < 1) ? 'bg-secondary' : 'bg-danger') : 'bg-warning text-dark'"
                    >
                        <span x-text="cart.object.qty"></span>
{{--                        <input style="color:black;" x-model="qty" type="number">--}}
                    </span>
                </a>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="navigation.hamburgerOpen = ! navigation.hamburgerOpen"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': navigation.hamburgerOpen, 'inline-flex': ! navigation.hamburgerOpen }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! navigation.hamburgerOpen, 'inline-flex': navigation.hamburgerOpen }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': navigation.hamburgerOpen, 'hidden': ! navigation.hamburgerOpen}" class="hidden sm:hidden">
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('dashboard')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                @if (Auth::check())
                    <x-responsive-nav-link :href="route('shopping-cart')">
                        {{ __('Cart') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('user-profile')" class="text-success">
                        {{ __('UserProfile') }} {{ Auth::user()->name }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('logout')" class="text-danger">
                        {{ __('Logout') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('login')" class="text-danger">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                @endif
            </div>
        </div>
    </div>
</nav>

