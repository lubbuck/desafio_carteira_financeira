<th class="{{ $class ?? '' }}" style="{{ $style ?? '' }}">
    @if (isset($field))
        @php
            $requestField = isset($_GET['field']) ? $_GET['field'] : (isset($active) ? $field : '');
            $requestSort = $_GET['sort'] ?? null;
            $fieldInRequest = $requestField == $field;
            $atualSort = $fieldInRequest
                ? (in_array($requestSort, ['asc', 'desc'])
                    ? $requestSort
                    : (isset($start) && in_array($start, ['asc', 'desc'])
                        ? $start
                        : 'asc'))
                : (isset($start) && in_array($start, ['asc', 'desc'])
                    ? $start
                    : 'asc');
            $nextSort = $fieldInRequest ? ($atualSort == 'asc' ? 'desc' : 'asc') : $atualSort;
            $url = request()->url() . '?' . Arr::query(array_merge($_GET, ['field' => $field, 'sort' => $nextSort]));
        @endphp
        <a class="{{ $fieldInRequest ? 'text-primary' : '' }}" href="{{ $url }}">
            @if ($fieldInRequest)
                <i class="bx bx-sort-{{ $atualSort == 'asc' ? 'down' : ($atualSort == 'desc' ? 'up' : '') }}"></i>
            @else
                <i class="bx bx-sort-alt-2"></i>
            @endif
            {{ $title }}
        </a>
    @else
        {{ $title }}
    @endif
</th>
