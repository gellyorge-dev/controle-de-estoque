@props(['search' => '', 'count' => '', 'searchPlaceholder' => 'Buscar…'])

<div class="table-card">
    @if($search !== false && $search !== 'false')
    <div class="table-toolbar">
        @if($search)
        <input class="search-input" placeholder="{{ $searchPlaceholder }}"
               oninput="filterTable(this, '{{ $search }}')">
        @endif
        @if($count)
        <span class="form-hint">{{ $count }}</span>
        @endif
        {{ $toolbar ?? '' }}
    </div>
    @endif
    <table>
        @isset($header)
        <thead>
            <tr>
                {{ $header }}
            </tr>
        </thead>
        @endisset
        <tbody id="{{ $search }}">
            {{ $slot }}
        </tbody>
    </table>
</div>
