<li class="nav-item dropdown" id="main-{{ $child2->attributes['id'] }}">
    <a class="dropdown-item" @if ($child2->url) href="{{ $child2->url }} @endif">
        @if($child2->attributes['icon_class'] ?? null)
            <span class="{{ trim($child2->attributes['icon_class']) }}"></span>
            @endif

            {{ __($child2->title) }}

            @if($child2Count) &raquo;
        @endif
    </a>
    @if($child2Count)
        <ul class="dropdown submenu">
            @foreach($child2->children as $child3)
                @include('inc.nav-L3')
                @if(!$child3->title)
                    @continue
                @endif
            @endforeach
        </ul>
    @endif
</li>