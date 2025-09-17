<ol class="dd-list">
	@foreach($children as $child)
	<li class="dd-item" data-link="{{ $child->link }}" data-type="{{ $child->type }}" data-name="<?= $child->name; ?>" data-id="<?= $child->menu_itemable_id; ?>">
	  <div class="dd-handle">{{ $child->name }}</div>
	  @if($child->children()->orderBy('display_order', 'asc')->get())
        @include('admin.menus.child-menu', ['children' => $child->children()->orderBy('display_order', 'asc')->get()])
	  @endif
	</li>
	@endforeach
</ol>
