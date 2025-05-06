@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
  <div class="d-flex flex-wrap align-items-start">
    <!-- Logo a la izquierda -->
    <div class="me-4">
      <img style="width: 30rem; border-radius: 2rem; margin: 1rem; box-shadow: 1px 1px 20px rgba(0,0,0,0.9);" src="{{ asset('assets/img/logo.jpg') }}" alt="Logo">
    </div>

    <!-- Contenido a la derecha -->
    <div class="flex-grow-1">
      <div class="row">
        <div class="col-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center gap-3">
                  <div class="avatar">
                    <span class="avatar-initial bg-label-primary rounded-circle"><i class="bx bx-user fs-4"></i></span>
                  </div>
                  <div class="card-info">
                    @foreach($buscarToken as $row)
                      <h5 class="card-title mb-0">{{ $row }}</h5>
                    @endforeach
                    <small class="text-muted">Tokens</small>
                  </div>
                </div>
                <div id="conversationChart"></div>
              </div>
            </div>
          </div>
        </div>

        <li class="d-flex mb-4 pb-2">
          <div class="avatar avatar-sm flex-shrink-0 me-3">
            <span class="avatar-initial rounded-circle bg-label-primary"><i class='bx bx-cube'></i></span>
          </div>
          <div class="d-flex flex-column w-100">
            <div class="d-flex justify-content-between mb-1">
              <span>Total basura vaciada</span>
              <span class="text-muted">{{ number_format($totalesVaciados, 2) }} kg</span>
            </div>
            <div class="progress" style="height:6px;">
              <div class="progress-bar bg-primary" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
          </div>
        </li>

@endsection

