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

    $user = User::create([
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

    // Asignar el rol automáticamente
    $user->assignRole('escritor'); // aquí el rol que quieres por defecto

    return $user;

    }
}
