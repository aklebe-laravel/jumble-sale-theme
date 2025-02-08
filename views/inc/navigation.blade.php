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
            <div class="d-block w-100 d-lg-flex">

                <nav class="navbar navbar-expand-lg navbar-light w-100">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
                        <button class="navbar-toggler" type="button"
                                data-bs-toggle="collapse"
                                data-bs-auto-close="outside"
                                data-bs-target="#navbarHeaderMain"
                                aria-controls="navbarHeaderMain"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarHeaderMain">

                            {{-- Navigation --}}
                            <ul class="navbar-nav align-items-lg-center me-auto mb-2 mb-lg-0">
                                @foreach($navigation->children as $navItem)
                                    @include('inc.nav-L1')
                                @endforeach

                                {{-- Search --}}
                                {{-- added "d-lg-none d-xl-flex" because its messed up in this range --}}
                                <li class="nav-item d-lg-none d-xl-flex">
                                    <form action="{{ route('search') }}" method="post">
                                        @csrf
                                        <span class="d-flex mr-2">
                                            <input class="form-control" type="search" name="search" placeholder="{{ __('Search') }}"
                                                   aria-label="{{ __('Search') }}">
                                            <button class="btn btn-outline-secondary" type="submit"><span class="bi bi-search"></span></button>
                                        </span>
                                    </form>
                                </li>

                                {{-- User Profile --}}
                                <li class="nav-item dropdown text-nowrap d-flex">
                                    <span class="nav-link text-nowrap w-100"
                                          id="navbarHeaderProfile"
                                          role="button"
                                          aria-expanded="false"
                                          data-bs-toggle="dropdown"
                                          aria-haspopup="true"
                                    >
                                        <span class="float-start text-center">
                                            <span class="text-nowrap text-success">
                                                <span class="bi bi-person-circle"></span> {{ (Auth::check()) ? Auth::user()->name : __('Not logged in') }}
                                            </span>
                                            @if((Auth::check()))
                                                @if (app('market_settings')->canShowUserRating())
                                                    <span class="small"
                                                          x-data="{ratingContainer:{rating5:{{ Auth::user()->rating5 }}, show_value: false}}">@include('form::components.alpine.rating')
                                                    </span>
                                                @endif
                                            @endif
                                        </span>
                                        <span class="float-end items-center flex h-100 opacity-75">
                                            <span class="bi bi-caret-down-fill"></span>
                                        </span>
                                    </span>
                                    {{-- User Profile Drowdown --}}
                                    <ul class="dropdown-menu" aria-labelledby="navbarHeaderProfile">
                                        @if (Auth::check())
                                            <li class="nav-item">
                                                <a class="nav-link text-success" aria-current="page" href="{{ route('user-profile') }}">{{ __('UserProfile') }}</a>
                                            </li>
                                            @foreach($testUsers as $testUser)
                                                <li class="nav-item">
                                                    <a class="nav-link text-danger-emphasis" aria-current="page"
                                                       href="{{ route('user.claim', $testUser->shared_id) }}">{{ __('Login: :name', ['name' => $testUser->name]) }}</a>
                                                </li>
                                            @endforeach
                                            <li class="nav-item">
                                                <a class="nav-link" aria-current="page" href="{{ route('logout') }}">{{ __('Logout') }}</a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link" aria-current="page" href="{{ route('login') }}">{{ __('Login') }}</a>
                                            </li>
                                        @endif

                                    </ul>
                                </li>

                                {{-- Cart --}}
                                <li class="nav-item">
                                    <a class="text-nowrap mini-cart nav-link ml-2 position-relative" href="{{ route('shopping-cart') }}">
                                        <span class="bi bi-cart"></span>
                                        <span class="">{{ __('Shopping Cart') }}
                                            <span class="position-absolute start-100 translate-middle badge rounded-pill"
                                                  :class="(cart.isLoaded) ? ((cart.object.qty < 1) ? 'bg-secondary' : 'bg-danger') : 'bg-warning text-dark'"
                                            >
                                                <span x-text="cart.object.qty"></span>
                                            </span>
                                        </span>
                                    </a>
                                </li>


                            </ul>

                        </div>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</nav>

