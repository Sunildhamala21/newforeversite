@props(['field', 'type' => 'text', 'required' => false, 'value' => null, 'label' => null])
<div>
    <label for="{{ $field }}" class="text-sm">
        {{ $label ?? str($field)->replace('_', ' ')->ucfirst() }}
        @if ($required)
            <span>*</span>
        @endif
    </label>
    @if ($type === 'textarea')
        <textarea name="{{ $field }}"
            class="w-full px-4 py-3 text-lg rounded-md bg-gray-50 border-slate-300 placeholder:text-slate-300"
            placeholder="{{ str($field)->replace('_', ' ')->ucfirst() }}" id="{{ $field }}"
            @if ($required) required @endif>{{ old($field) ?? $value }}</textarea>
    @else
        <input type="{{ $type }}" name="{{ $field }}"
            class="w-full px-4 py-3 text-lg rounded-md bg-gray-50 border-slate-300 placeholder:text-slate-300"
            placeholder="{{ str($field)->replace('_', ' ')->ucfirst() }}" value="{{ old($field) ?? $value }}"
            id="{{ $field }}" {{ $attributes }} @if ($required) required @endif>
    @endif
    @error($field)
        <div class="text-sm text-red-500">{{ $message }}</div>
    @enderror
</div>
