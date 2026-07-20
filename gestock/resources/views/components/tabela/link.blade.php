@props(['href' => ''])

<a href="{{ $href }}" class="ref-chip" {{ $attributes }}>
    {{ $slot }}
</a>
