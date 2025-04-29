@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Page 2')

@section('content')
  <h1>Registrar Recolectores</h1>

{{--  @if(session('success'))--}}
{{--    <div id="modalclose" class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">--}}
{{--      <i class="bx bx-xs bx-desktop me-2"></i>--}}
{{--      Se registro correctamente--}}
{{--      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">--}}
{{--      </button>--}}
{{--    </div>--}}
{{--  @else--}}

{{--  @endif--}}
{{--  <!-- Basic with Icons -->--}}
{{--  <div class="col-xxl">--}}
{{--    <div class="card mb-4">--}}
{{--      <div class="card-header d-flex align-items-center justify-content-between">--}}
{{--        <h5 class="mb-0">Registrar recolector</h5> <small class="text-muted float-end">Usuarios</small>--}}
{{--      </div>--}}
{{--      <div class="card-body">--}}
{{--        <form id="formulario" action=" {{ route('user-control.store') }}" method="POST">--}}
{{--          @csrf--}}
{{--          @method('POST')--}}
{{--          <div class="row mb-3">--}}
{{--            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nombres</label>--}}
{{--            <div class="col-sm-10">--}}
{{--              <div class="input-group input-group-merge">--}}
{{--                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>--}}
{{--                <input required name="input_name" type="text" class="form-control" id="basic-icon-default-fullname"--}}
{{--                       placeholder="Nombres" aria-label="John Doe" aria-describedby="basic-icon-default-fullname2"/>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div class="row mb-3">--}}
{{--            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Apellidos</label>--}}
{{--            <div class="col-sm-10">--}}
{{--              <div class="input-group input-group-merge">--}}
{{--                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="bx bx-user"></i></span>--}}
{{--                <input required name="input_apellidos" type="text" id="basic-icon-default-company" class="form-control"--}}
{{--                       placeholder="Apellidos" aria-label="ACME Inc." aria-describedby="basic-icon-default-company2"/>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div class="row mb-3">--}}
{{--            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>--}}
{{--            <div class="col-sm-10">--}}
{{--              <div class="input-group input-group-merge">--}}
{{--                <span class="input-group-text"><i class="bx bx-envelope"></i></span>--}}
{{--                <input required name="input_email" type="email" id="basic-icon-default-email" class="form-control"--}}
{{--                       placeholder="john.doe" aria-label="john.doe" aria-describedby="basic-icon-default-email2"/>--}}
{{--                <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>--}}
{{--              </div>--}}
{{--              <div class="form-text"> You can use letters, numbers & periods</div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div class="row mb-3">--}}
{{--            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Num. Telefonico</label>--}}
{{--            <div class="col-sm-10">--}}
{{--              <div class="input-group input-group-merge">--}}
{{--                <span id="basic-icon-default-phone2" class="input-group-text"><i class="bx bx-phone"></i></span>--}}
{{--                <input required name="input_telefono" type="text" id="basic-icon-default-phone" class="form-control phone-mask"--}}
{{--                       placeholder="658 799 8941" aria-label="658 799 8941"--}}
{{--                       aria-describedby="basic-icon-default-phone2"/>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div class="row mb-3">--}}
{{--            <div class="col-sm-10">--}}
{{--              <div class="input-group input-group-merge">--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--          <div class="row justify-content-end">--}}
{{--            <div class="col-sm-10">--}}
{{--              <button  id="btnEnviar type="submit" class="btn btn-primary">Registrar</button>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </form>--}}
{{--      </div>--}}
{{--    </div>--}}
{{--  </div>--}}
{{--  </div>--}}

{{--  @if(session('modal_error'))--}}
{{--    <!-- Modal -->--}}
{{--    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">--}}
{{--      <div class="modal-dialog">--}}
{{--        <div class="modal-content">--}}
{{--          <div class="modal-header bg-danger text-white">--}}
{{--            <h5 class="modal-title" id="errorModalLabel">Error en el registro</h5>--}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>--}}
{{--          </div>--}}
{{--          <div class="modal-body">--}}
{{--            {{ session('modal_error') }}--}}
{{--          </div>--}}
{{--          <div class="modal-footer">--}}
{{--            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>--}}
{{--          </div>--}}
{{--        </div>--}}
{{--      </div>--}}
{{--    </div>--}}

{{--    <div id="loading" style="display: none;">--}}
{{--      <p>Enviando datos, por favor espere...</p>--}}
{{--    </div>--}}

{{--    <script>--}}

{{--      document.getElementById('formulario').addEventListener('submit', function() {--}}
{{--        // Mostrar el mensaje de cargando--}}
{{--        document.getElementById('loading').style.display = 'block';--}}

{{--        // Deshabilitar el botón para evitar envíos múltiples--}}
{{--        document.getElementById('btnEnviar').disabled = true;--}}
{{--      });--}}
{{--    </script>--}}

{{--    <script>--}}
{{--      document.addEventListener('DOMContentLoaded', function () {--}}
{{--        var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));--}}
{{--        errorModal.show();--}}
{{--      });--}}
{{--    </script>--}}
{{--  @endif--}}

{{--  <script>--}}

{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--      const timeModal = document.getElementById('modalclose');--}}
{{--      if (timeModal) {--}}
{{--        setTimeout(function () {--}}
{{--          timeModal.style.display = 'none';--}}
{{--          console.log('Modal cerrado automáticamente');--}}
{{--        }, 1000); // 1 segundo--}}
{{--      }--}}
{{--    });--}}

{{--  </script>--}}

{{--  ----------------------------------}}





  @section('page-style')
    {{-- Page Css files --}}
    <link rel="stylesheet" href="{{ asset(mix('assets/vendor/css/pages/page-auth.css')) }}">
  @endsection

  @section('content')
    <div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
          <div class="flex-row text-center mx-auto">
            {{-- <img src="{{asset('assets/img/pages/register-'.$configData['style'].'.png')}}" alt="Auth Cover Bg color"
              width="520" class="img-fluid authentication-cover-img" data-app-light-img="pages/register-light.png"
              data-app-dark-img="pages/register-dark.png"> --}}
            <div class="mx-auto">
              <img style="width: 25rem; border-radius: 5rem; margin: 1rem; box-shadow: 1px 1px 20px rgba(0,0,0,0.9);"
                   src="{{ asset('assets/img/logo.jpg') }}" alt="Logo">

            </div>
          </div>
        </div>
        <!-- /Left Text -->

        <!-- Register Card -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
          <div class="w-px-400 mx-auto">
            <!-- Logo -->
            <div class="app-brand mb-4">
              <a href="{{url('/')}}" class="app-brand-link gap-2 mb-2">
                {{-- <span class="app-brand-logo demo">@include('_partials.macros')</span> --}}
                {{-- <span class="app-brand-text demo h3 mb-0 fw-bold">{{config('variables.templateName')}}</span> --}}
              </a>
            </div>
            <!-- /Logo -->

            <!-- Register Card -->
            <h4 class="mb-2">Registrar recolector</h4>
            <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
              @csrf


              <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Juan"
                       value="{{ old('nombres') }}" />
              </div>

              <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Pérez"
                       value="{{ old('apellidos') }}" />
              </div>

              <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="CDMX"
                       value="{{ old('ciudad') }}" />
              </div>

              <div class="mb-3">
                <label for="colonia" class="form-label">Colonia</label>
                <input type="text" class="form-control" id="colonia" name="colonia" placeholder="Centro"
                       value="{{ old('colonia') }}" />
              </div>

              <div class="mb-3">
                <label for="numero_exterior" class="form-label">Número Exterior</label>
                <input type="text" class="form-control" id="numero_exterior" name="numero_exterior" placeholder="123"
                       value="{{ old('numero_exterior') }}" />
              </div>

              <div class="mb-3">
                <label for="descripcion_vivienda" class="form-label">Descripción Vivienda</label>
                <textarea class="form-control" id="descripcion_vivienda" name="descripcion_vivienda"
                          placeholder="Casa de dos pisos, color azul">{{ old('descripcion_vivienda') }}</textarea>
              </div>

              {{-- datos del empledo --}}

              <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="username"
                       placeholder="johndoe" autofocus value="{{ old('name') }}" />
                @error('name')
                <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
                @enderror
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       placeholder="john@example.com" value="{{ old('email') }}" />
                @error('email')
                <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
                @enderror
              </div>
              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password">Contraseña</label>
                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                         name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                         aria-describedby="password" />
                  <span class="input-group-text cursor-pointer">
                <i class="bx bx-hide"></i>
              </span>
                </div>
                @error('password')
                <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
                @enderror
              </div>

              <div class="mb-3 form-password-toggle">
                <label class="form-label" for="password-confirm">Confirme su contraseña</label>
                <div class="input-group input-group-merge">
                  <input type="password" id="password-confirm" class="form-control" name="password_confirmation"
                         placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                         aria-describedby="password" />
                  <span class="input-group-text cursor-pointer">
                <i class="bx bx-hide"></i>
              </span>
                </div>
              </div>
              @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mb-1">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms" name="terms" />
                    <label class="form-check-label" for="terms">
                      I agree to the
                      <a href="{{ route('terms.show') }}" target="_blank">
                        terms_of_service
                      </a> and
                      <a href="{{ route('policy.show') }}" target="_blank">
                        privacy_policy
                      </a>
                    </label>
                  </div>
                </div>
              @endif
              <button type="submit" class="btn btn-primary d-grid w-100">Registrar</button>
            </form>
            </div>
          </div>
        </div>
        <!-- Register Card -->
      </div>
    </div>
  @endsection

  {{--  @include('example-content.user-interface.ui-alerts')--}}
@endsection
