@props(['title' => '', 'description' => '', 'button' => ''])

<div class="page-head">
    <div>
        <h1>{{ $title }}</h1>
        @if($description)<p>{{ $description }}</p>@endif
    </div>
    @if($button)
        {!! $button !!}
    @endif
</div>
