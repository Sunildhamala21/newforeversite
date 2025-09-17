<nav :class="{ show: mobilenavOpen }">
    <ul id="main-nav" class="absolute sm sm-simple lg:static" style="top:100%;left:0;right:0;">
        @if ($menus)
            @foreach ($menus as $menu)
                <li>
                    <a href="{!! $menu->link ? $menu->link : 'javascript:;' !!}" class="text-gray-600 lg:text-white">{{ $menu->name }}</a>
                    @if (iterator_count($menu->children))
                        @if ($menu->mega_menu)
                            @include('front.elements.mega_menu', ['menu' => $menu])
                        @else
                            <ul>
                                @foreach ($menu->children()->orderBy('display_order', 'asc')->get() as $child)
                                    <li>
                                        <a href="{!! $child->link ? $child->link : 'javascript:;' !!}">{{ $child->name }}</a>
                                        @if (iterator_count($child->children))
                                            @include('front.elements.child-menu', [
                                                'children' => $child->children()->orderBy('display_order', 'asc')->get(),
                                                'n_count' => 2,
                                            ])
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    @endif
                </li>
            @endforeach
        @endif
    </ul>
</nav>
