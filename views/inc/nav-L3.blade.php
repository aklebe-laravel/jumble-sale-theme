@if(!$child3->title)
    <li>
        <hr class="dropdown-divider">
    </li>
@else
    @php
        $child3Count = count($child3->children)
    @endphp
    <li id="main-{{ $child3->attributes['id'] }}">
        <a class="dropdown-item" href="{{ $child3->url }}">
            @if($child3->attributes['icon_class'] ?? null)
                <span class="{{ trim($child3->attributes['icon_class']) }}"></span>
                @endif

                {{ __($child3->title) }}
                @if($child3Count) &raquo;
            @endif
        </a>
    </li>
@endif