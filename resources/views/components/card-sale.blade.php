<div class="col-xl mb-lg-0 lg-4">
  <div class="card border shadow-none">
    <div class="card-body">
      <h5 class="text-start text-uppercase">{{ $title }}</h5>

      <div class="text-center position-relative mb-4 pb-1">
        <div class="mb-2 d-flex">
          <h1 class="price-toggle text-primary price-yearly mb-0">{{ $price }}</h1>
        </div>
      </div>
      <p>{{ $description }}</p>
      <hr>
      <a href="{{url('auth/register-basic')}}" class="btn btn-label-primary d-grid w-100">{{ $buttonName }}</a>
    </div>
  </div>
</div>
