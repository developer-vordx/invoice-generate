@props([
    'label' => '',
    'name' => '',
    'value' => '',
    'type' => 'text',
    'step' => null,
    'placeholder' => '',
])

<div class="space-y-1">
    @if($label)
        <label for="{{ $name }}" class="block text-gray-700 font-medium">{{ $label }}</label>
    @endif
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        step="{{ $step }}"
        value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}"
        class="w-full border border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
    >
</div>
