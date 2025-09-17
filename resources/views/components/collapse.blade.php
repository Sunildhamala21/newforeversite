@props(['loop' => null, 'open' => 'false'])
<div x-data="{ open: {{ $open }} }" {{ $attributes->class([]) }}>
    {{ $slot }}
    <button {{ $trigger->attributes->class(['cursor-pointer']) }} x-on:click="open = !open">
        {{ $trigger }}
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="flex-shrink-0 transition size-6" x-bind:class="{ 'rotate-180': open }" viewBox="0 0 16 16">
            <path fill-rule="evenodd"
                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
        </svg>
    </button>
    <div x-show="open" x-collapse x-cloak>
        <div class="py-1">{{ $target }}</div>
    </div>
</div>
