@if(!$navItem->title)
    <li>
        <hr class="dropdown-divider">
    </li>
@else
    @if($navItem->children)
        <li class="nav-item dropdown" id="main-{{ $navItem->attributes['id'] }}">
            <button class="nav-link dropdown-toggle" role="button"
                    data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
                @if($navItem->attributes['icon_class'] ?? null)
                    <span class="{{ trim($navItem->attributes['icon_class']) }}"></span>
                @endif
                {{ __($navItem->title) }}
            </button>
            <ul class="dropdown-menu">
                @foreach($navItem->children as $child2)
                    @if(!$child2->title)
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        @continue
                    @endif
                    @php
                        $child2Count = count($child2->children)
                    @endphp
                        @include('inc.nav-L2')
                @endforeach
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link {{ ($navItem->active ?? false) ? 'active' : '' }}"
               aria-current="page"
               href="{{ $navItem->url }}">{{ __($navItem->title) }}</a>
        </li>
    @endif
@endif