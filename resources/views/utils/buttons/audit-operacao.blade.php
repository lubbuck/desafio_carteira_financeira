@include('utils.buttons.link', [
    'title' => 'Ver Auditoria deste Registro',
    'route' => 'sistema.auditoria.operacoes',
    'class' => 'btn btn-sm ' . (session('layout_theme') === 'light-style' ? 'btn-outline-dark' : 'btn-dark'),
    'icon' => 'bx bx-calendar-check',
])
