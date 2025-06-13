<div class="card shadow-sm">
    <div class="card-header">
        @if(isset($title))
            <h5 class="mb-0">{{ $title }}</h5>
        @endif
    </div>
    <div class="card-body">
        @if(isset($filters))
            <div class="mb-3">
                {{ $filters }}
            </div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        {{ $head }}
                    </tr>
                </thead>
                <tbody>
                    {{ $body }}
                </tbody>
            </table>
        </div>

        @if(isset($pagination))
            <div class="mt-3">
                {{ $pagination }}
            </div>
        @endif
    </div>
</div>