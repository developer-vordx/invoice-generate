@props(['label' => '', 'name' => '', 'value' => '', 'rows' => 3])

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-gray-700 font-medium">{{ $label }}</label>
    @endif
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
    >{{ old($name, $value) }}</textarea>
</div>
