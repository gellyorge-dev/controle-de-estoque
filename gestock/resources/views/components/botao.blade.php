@props(['variant' => '', 'href' => '', 'type' => 'button', 'size' => ''])

@php
    $classes = 'btn';
    if ($variant) $classes .= ' btn-' . $variant;
    if ($size) $classes .= ' btn-' . $size;
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $classes }}" {{ $attributes }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $classes }}" {{ $attributes }}>
        {{ $slot }}
    </button>
@endif
