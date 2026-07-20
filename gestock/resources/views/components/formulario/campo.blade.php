@props(['label' => '', 'required' => false, 'span' => ''])

<div class="form-field @if($span === '2') span-2 @endif" {{ $attributes }}>
    @if($label)
    <label>
        {{ $label }}
        @if($required)<span class="req">*</span>@endif
    </label>
    @endif
    {{ $slot }}
</div>
