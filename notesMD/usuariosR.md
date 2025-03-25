# Creacion de la base de datos 


# Que es lo que necesito?

cuando registro un usuario, el usuario debe tener algunos datos, pero veo que el modelo usuarios esta realizando el registro
del nombre de usuario, entre otras mas, requiero que el usuario pueda registrar mas datos, por ejemplo nombre, apellido etc.
el problema es que en el registro al registrar el usuario con la clave etc, quiero que se registre los datos
del usuario concatenado a ese usuario.

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
ahora como podras notar necesito que guarde estos datos, el token no se registra ya que eso 
se los ganara el cliente cuando cumpla algunos retos 