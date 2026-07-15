@props(['items' => []])
{{-- items: [['label' => '...', 'href' => '...', 'active' => bool]] --}}

<nav class="subnav">
    @foreach($items as $item)
        <a class="subnav-btn {{ ($item['active'] ?? false) ? 'active' : '' }}" href="{{ $item['href'] }}">{{ $item['label'] }}</a>
    @endforeach
</nav>
