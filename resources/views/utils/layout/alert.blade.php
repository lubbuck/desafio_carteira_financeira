@php
    $strong = $strong ?? false;
    $fade = $fade ?? false;
@endphp
<div class="alert alert-{{ $color ?? 'primary' }} {{ $strong ? 'alert-alt' : '' }} {{ $fade ? 'alert-dismissible fade show' : '' }} mb-3"
    role="alert">
    @if ($strong)
        <b>{{ $text }}</b>
    @else
        {{ $text }}
    @endif
    @if ($fade)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
