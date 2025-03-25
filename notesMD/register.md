# Registrar usuario 

###### Constrolador

```php
<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterBasic extends Controller
{
  public function index()
  {
    $pageConfigs = ['myLayout' => 'blank'];
    return view('content.authentications.auth-register-basic', ['pageConfigs' => $pageConfigs]);
  }
}

```

###### Modelo 

```php

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'nombres',
        'apellidos',
        'ciudad',
        'colonia',
        'numero_exterior',
        'descripcion_vivienda',
        'tokens',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
```


###### tabla usuarios

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Nombre de usuario
            $table->string('nombres'); // Nombre completo
            $table->string('apellidos');
            $table->string('ciudad');
            $table->string('colonia');
            $table->string('numero_exterior');
            $table->text('descripcion_vivienda')->nullable();
            $table->double('tokens', 8, 2)->default(0); // Tokens con dos decimales, inicia en 0
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
```
Quiero registrar datos del usuario pero tambien quiero registrar algunos datos adicionales 

```html
@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register Page')

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
        {{-- <img src="{{asset('assets/img/pages/register-'.$configData['style'].'.png')}}" alt="Auth Cover Bg color" width="520" class="img-fluid authentication-cover-img" data-app-light-img="pages/register-light.png" data-app-dark-img="pages/register-dark.png"> --}}
        <div class="mx-auto">
          <img style="width: 25rem; border-radius: 5rem; margin: 1rem; box-shadow: 1px 1px 20px rgba(0,0,0,0.9);" src="{{ asset('assets/img/logo.jpg') }}" alt="Logo">
          <h3>Registrate y comienza a mejorar tu economia y a su vez el medio ambiente</h3>
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
        <h4 class="mb-2">Registrarme</h4>
        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
          @csrf

          {{-- datos del empledo --}}

          <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name" placeholder="johndoe" autofocus value="{{ old('name') }}" />
            @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>        
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" />
            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
          <div class="mb-3 form-password-toggle">
            <label class="form-label" for="password">Contraseña</label>
            <div class="input-group input-group-merge @error('password') is-invalid @enderror">
              <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
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
              <input type="password" id="password-confirm" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
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

        <p class="text-center mt-2">
          <span>Ya esta registrado?</span>
          @if (Route::has('login'))
          <a href="{{ route('login') }}">
            <span>Iniciar sesion</span>
          </a>
          @endif
        </p>

        <div class="divider my-4">
          <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center">
          <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
            <i class="tf-icons bx bxl-facebook"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
            <i class="tf-icons bx bxl-google-plus"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon btn-label-twitter">
            <i class="tf-icons bx bxl-twitter"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
@endsection

```


---- 

##### Errores 


A form field element should have an id or name attribute
An element doesn't have an autocomplete attribute
Incorrect use of <label for=FORM_ELEMENT>
The label's for attribute doesn't match any element id. This might prevent the browser from correctly autofilling the form and accessibility tools from working correctly.

To fix this issue, make sure the label's for attribute references the correct id of a form field.

3 resources
Violating node
Violating node
Violating node
Learn more: The label elements

```php
<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'username',
        'nombres',
        'apellidos',
        'ciudad',
        'colonia',
        'numero_exterior',
        'descripcion_vivienda',
        'tokens',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];
}
@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register Page')

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
          <h3>Registrate y comienza a mejorar tu economia y a su vez el medio ambiente</h3>
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
        <h4 class="mb-2">Registrarme</h4>
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
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name"
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

        <p class="text-center mt-2">
          <span>Ya esta registrado?</span>
          @if (Route::has('login'))
          <a href="{{ route('login') }}">
            <span>Iniciar sesion</span>
          </a>
          @endif
        </p>

        <div class="divider my-4">
          <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center">
          <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
            <i class="tf-icons bx bxl-facebook"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
            <i class="tf-icons bx bxl-google-plus"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon btn-label-twitter">
            <i class="tf-icons bx bxl-twitter"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
@endsection

```


id	NO
username	NO
nombres	NO
apellidos	NO
ciudad	NO
colonia	NO
numero_exterior	NO
email	NO
password	NO
CURRENT_CONNECTIONS	NO
TOTAL_CONNECTIONS	NO
descripcion_vivienda	YES
tokens	YES
email_verified_at	YES
two_factor_secret	YES
two_factor_recovery_codes	YES
two_factor_confirmed_at	YES
remember_token	YES
created_at	YES
updated_at	YES
USER	YES
```php
@php
$configData = Helper::appClasses();
$customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/blankLayout')

@section('title', 'Register Page')

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
          <h3>Registrate y comienza a mejorar tu economia y a su vez el medio ambiente</h3>
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
        <h4 class="mb-2">Registrarme</h4>
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
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="username" name="name"
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

        <p class="text-center mt-2">
          <span>Ya esta registrado?</span>
          @if (Route::has('login'))
          <a href="{{ route('login') }}">
            <span>Iniciar sesion</span>
          </a>
          @endif
        </p>

        <div class="divider my-4">
          <div class="divider-text">or</div>
        </div>

        <div class="d-flex justify-content-center">
          <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
            <i class="tf-icons bx bxl-facebook"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
            <i class="tf-icons bx bxl-google-plus"></i>
          </a>

          <a href="javascript:;" class="btn btn-icon btn-label-twitter">
            <i class="tf-icons bx bxl-twitter"></i>
          </a>
        </div>
      </div>
    </div>
    <!-- Register Card -->
  </div>
</div>
@endsection
<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    // public function create(array $input)
    // {
    //     Validator::make($input, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => $this->passwordRules(),
    //         'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
    //     ])->validate();

    //     return User::create([
    //         'name' => $input['name'],
    //         'email' => $input['email'],
    //         'password' => Hash::make($input['password']),
    //     ]);
    // }
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'ciudad' => ['required', 'string', 'max:255'],
            'colonia' => ['required', 'string', 'max:255'],
            'numero_exterior' => ['required', 'string', 'max:255'],
            'descripcion_vivienda' => ['nullable', 'string'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        return User::create([
            'username' => $input['username'],
            'nombres' => $input['nombres'],
            'apellidos' => $input['apellidos'],
            'ciudad' => $input['ciudad'],
            'colonia' => $input['colonia'],
            'numero_exterior' => $input['numero_exterior'],
            'descripcion_vivienda' => $input['descripcion_vivienda'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Nombre de usuario
            $table->string('nombres'); // Nombre completo
            $table->string('apellidos');
            $table->string('ciudad');
            $table->string('colonia');
            $table->string('numero_exterior');
            $table->text('descripcion_vivienda')->nullable();
            $table->double('tokens', 8, 2)->default(0)->nullable(); // Tokens con dos decimales, inicia en 0
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
```