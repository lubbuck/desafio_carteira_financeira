@include('utils.buttons.link', [
    'title' => 'Ver Acessos',
    'route' => 'sistema.auditoria.acessos',
    'class' => 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-dark' : 'btn-dark'),
    'icon' => 'bx bx-door-open',
])
