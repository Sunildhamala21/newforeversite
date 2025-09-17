@props(['name', 'icon'])
<li>
    <a href="#{{ str($name)->slug() }}" class="flex items-center gap-1 p-2 hover:bg-white hover:text-primary">
        <x-dynamic-component :component="$icon" class="size-5" />
        <span class="hidden md:block text-sm font-semibold">{{ $name }}</span>
    </a>
</li>
