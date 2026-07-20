@props(['variant' => 'ok'])

<span class="badge badge-{{ $variant }}" {{ $attributes }}>
    {{ $slot }}
</span>
