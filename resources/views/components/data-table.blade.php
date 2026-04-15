<div class="card">
    @if($title || $createUrl)
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ $title }}</h5>
            @if($createUrl)
                <a href="{{ $createUrl }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> {{ $createLabel }}
                </a>
            @endif
        </div>
    @endif
    <div class="card-body">
        {{ $slot }}
    </div>
</div>
