<div class=" cont-margin w-full max-w-sm  p-4 rounded-lg  ">
    <div class=" card h-100">
        <div class="card-header">
            <h3 class="card-title mb-2">{{ $title }}</h3>
            <span class="text-nowrap">{{ $desc }}</span>
        </div>
        <div class=" card-body">
            <div class="row align-items-end">
                <div class="col-6">
                    <h1 class="display-6 text-primary mb-2 pt-3 pb-1"> {{ $kg }}Kg</h1>
                    <small class="d-block mb-3">{{ $info }}</small>
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
