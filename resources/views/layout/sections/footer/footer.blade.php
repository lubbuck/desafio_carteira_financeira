<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">
            © {{ date('Y') }}, Desenvolvido por <a href="{{ config('project.layout.footer.link') }}" target="_blank"
                class="footer-link fw-bolder">{{ config('project.layout.footer.text_link') }}</a>
        </div>
        <div>
            @foreach (config('project.layout.footer.links') as $name => $url)
                <a href="{{ $url }}" class="footer-link me-4 {{ $loop->last ? 'd-sm-inline-block' : '' }}"
                    target="_blank">{{ $name }}</a>
            @endforeach
        </div>
    </div>
</footer>
