@php
    $route_groups = \Dds\Classes\DDS::groupRoutes($routes);
@endphp

<div class="modal fade" id="rotas-{{ $id ?? null }}" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rotas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @foreach ($route_groups as $group => $sub_grops)
                    <b class="text-primary">{{ $group }}</b>
                    <div class="ps-3">
                        @if ($group == '')
                            @foreach ($sub_grops as $rt)
                                <div>{{ $rt['name'] }}</div>
                            @endforeach
                        @else
                            @foreach ($sub_grops as $sub_group => $routes)
                                <b>{{ $sub_group }}</b>
                                <div class="{{ $sub_group == '' ? '' : 'ps-3' }}">
                                    @foreach ($routes as $rt)
                                        <div>{{ $rt['name'] }}</div>
                                    @endforeach
                                </div>
                            @endforeach
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#rotas-{{ $id ?? null }}">
    <b>Rotas</b>
</button>
