# Registrar los contenedores 

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
     
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
```

# tabla contenedores y pivote

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
        Schema::create('contenedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('numero_serie');
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
        Schema::dropIfExists('contenedores');
    }
};

```

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
        Schema::create('tipobasura', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('nombre');
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
        Schema::dropIfExists('tipobasura');
    }
};


```

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
        Schema::create('usuario_contenedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
            $table->foreignId('id_contenedor')->constrained('contenedores')->onDelete('cascade');
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
        Schema::dropIfExists('usuario_contenedor');
    }
};


```

como puedo registrar el contenedor y ligar todo 

```sql

Table division_contenedor {  
  id integer [primary key]
  id_contenedor integer [ref: > contenedores.id]  
  id_tipo_basura integer [ref: > tipobasura.id]  
  cantidad_kg DECIMAL(10,2)  
}
Table contenedores {
  id integer [primary key]
  nombre varchar
  numero_de_serie varchar
}
Table usuario_contenedor {   
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_contenedor integer [ref: > contenedores.id]
}
Table tipobasura {
  id integer [primary key]
  numero integer
  nombre varchar
}
Table vaciado_contenedor {
  id integer [primary key]
  id_division_contenedor integer [ref: > division_contenedor.id]  
  id_usuario integer [ref: > usuarios.id]
  fecha_vaciado DATETIME
  cantidad_vaciada DECIMAL(10,2)
}
Table historial_tokens {
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_vaciado integer [ref: > vaciado_contenedor.id]  
  tokens_asignados integer
  fecha_asignacion DATETIME
}

--- no se si falta algo mas 
Table usuarios {
  id integer [primary key]
  nombres varchar
  apellidos varchar
  ciudad varchar
  colonia varchar 
  numeroexterior varchar 
  descripcionvivienda varchar
  tokens double // Nuevo campo para almacenar los tokens del usuario
}

Table contenedores {
  id integer [primary key]
  nombre varchar
  numero_de_serie varchar
}

Table usuario_contenedor {   
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_contenedor integer [ref: > contenedores.id]
}

Table division_contenedor {  
  id integer [primary key]
  id_contenedor integer [ref: > contenedores.id]  
  id_tipo_basura integer [ref: > tipobasura.id]  
  cantidad_kg DECIMAL(10,2)  
}

Table tipobasura {
  id integer [primary key]
  numero integer
  nombre varchar
}

Table vaciado_contenedor {
  id integer [primary key]
  id_division_contenedor integer [ref: > division_contenedor.id]  
  id_usuario integer [ref: > usuarios.id]
  fecha_vaciado DATETIME
  cantidad_vaciada DECIMAL(10,2)
}

Table recompensas {
  id integer [primary key]
  imagen varchar
  titulo varchar 
  descripcion varchar
  precio integer // Se cambió a integer porque ahora representa el costo en tokens
}

Table historial_recompensas {
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_recompensa integer [ref: > recompensas.id]
  fecha_canje DATETIME
  tokens_gastados integer
}
Table historial_tokens {
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_vaciado integer [ref: > vaciado_contenedor.id]  
  tokens_asignados integer
  fecha_asignacion DATETIME
}

 


```