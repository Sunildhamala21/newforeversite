<ul>
  <!-- Level three dropdown-->
  @foreach($children as $child)
  <li>
    <a href="{!! ($child->link)?$child->link:'javascript:;' !!}">{{ $child->name }}</a>
      @if(iterator_count($child->children))
          @include('front.elements.child-menu', ['children' => $child->children()->orderBy('display_order', 'asc')->get(), 'n_count' => $n_count++])
      @endif
  </li>
  @endforeach
</ul>
