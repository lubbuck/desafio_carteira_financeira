@php
    $class = $class ?? 'btn btn-sm btn-success';
    $csrf = $csrf ?? true;
@endphp

@if ($csrf)
    @csrf
@endif

<button class="{{ $class }}" id="{{ $id ?? '' }}" type="submit" title="Salvar este Registro">
    @if (isset($icon))
        <i class="{{ $icon }}"></i>
    @endif
    {{ $text ?? 'Salvar' }}
</button>
