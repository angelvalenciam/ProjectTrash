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




Table tipobasura {
  id integer [primary key]
  numero integer
  nombre varchar
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

# pasos para poder registrar contendor correctamente 

1. primero debe existir un usuario el cual ingresara los datos necesarios para poder enlazar un usuario con un cotenedor 



> aqui genero los contenedores, este es el primer registro para poder generar todos los demas registros

```sql
Table contenedores {
  id integer [primary key]
  nombre varchar
  numero_serie varchar
}
```

---

> Para los tipo de basura ya los registre nada mas hay que tomar la tabla pivote la cual es division_contenedores, ya que se requiere un registro por cada division creada para el mismo contenedor
> por ejemplo se toma el id del contenedor y se registra con los 4 tipos de basura, 

| id  | numero | nombre      |
| --- | ---    | ------      | 
| 1   | 	1	   | Organico		 |
| 2   |	  2	   | Metales		 |
| 3	  |   3	   | Platicos		 |
| 4   |	  4	   | Inorganica	 |	
				
En base a lo dicho se debe registrar un contenedor con cuatro divisiones las cuales se deben guardar con el mismo id del contenedor registrafo anterior mente.

```sql
Table tipobasura {
  id integer [primary key]
  numero integer
  nombre varchar
}
```

---


> para poder tener el division de basura debo registrar un contenedor el cual se guarde el id, cuando se guarda el id, se guarda que cantidad de basura que tiene ese contenedor 
> por lo tanto necesito tener un contenedor registrado y los tipos de basura para poder generar el registro de esta tabla 


```sql
Table usuario_contenedor {   
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_contenedor integer [ref: > contenedores.id]
}
```

---

Aqui esta la tabla la cual contiene los tipos de basura 

| id  | numero | nombre      |
| --- | ---    | ------      | 
| 1   | 	1	   | Organico		 |
| 2   |	  2	   | Metales		 |
| 3	  |   3	   | Platicos		 |
| 4   |	  4	   | Inorganica	 |	


Ejemplo como se debe guardar para poder realizar el registro correctamente

| id  | id_contenedor | id_tipo_basura      | cantidad_kg     |
| --- | ---           | ------              |  ------         | 
| 1   | 	1	          | Organico		        |  100            |
| 2   |	  1	          | Metales		          |  200            |
| 3	  |   1	          | Platicos		        |  300            |
| 4   |	  1	          | Inorganica	        |  400            |	

es esta forma lo que hace es a un solo contenedor guardarle cierca cantidad de basura en su tipo de basura


por ahora lo hago local pero tenemos un arduino con python el cual toma los datos y llena la cantidad y a cual tipo pero con fines de pruebas necesito eso, entonces quiere decir que cuando el usuario guarde o mas bien registre su contenedor en automatico debe registrar las cuatro divisiones

```sql
Table division_contenedor {  
  id integer [primary key]
  id_contenedor integer [ref: > contenedores.id]  
  id_tipo_basura integer [ref: > tipobasura.id]  
  cantidad_kg DECIMAL(10,2)  
}
```



---


el vaciado del contenedor es importante porque tendre varios usuarios para que pueda pasar un recolector de basura pero el usuario debe marcar como vacio el contenedor. en base al id_division_contenedor se debe vaciar dependiendo el tipo de basura, ya que si por ejemplo se llena el contenedor de metales y solo quiere vaciar ese entonces solo esa division del contenedor se debe vaciar.


```sql
Table vaciado_contenedor {
  id integer [primary key]
  id_division_contenedor integer [ref: > division_contenedor.id]  
  id_usuario integer [ref: > usuarios.id]
  fecha_vaciado DATETIME
  cantidad_vaciada DECIMAL(10,2)
}
```

--- 

Aqui cuando se vacie un contenedor especifico por ejemplo metales, lo estamos pagando a 1000 puntos entonces cuando lo vacia va a multiplicar los kg por cuantos token se se gano ejemlo
metales lo pagamos a 10 puntos por cada kg de metal y asi  si son 10kg son 100 puntos 
entonces en base al id_usuario debe agregarle tokens 
```sql
Table historial_tokens {
  id integer [primary key]
  id_usuario integer [ref: > usuarios.id]
  id_vaciado integer [ref: > vaciado_contenedor.id]  
  tokens_asignados integer
  fecha_asignacion DATETIME
}
```

---


# resultado o solucion 

Para registrar un contenedor correctamente en Laravel y que automáticamente se creen las divisiones de basura, sigue estos pasos:

---

### **1. Crear las Migraciones**
Crea las migraciones necesarias para las tablas con:

```bash
php artisan make:migration create_contenedores_table
php artisan make:migration create_usuario_contenedor_table
php artisan make:migration create_division_contenedor_table
```

Luego, en la migración de `contenedores`, define la estructura:

```php
public function up()
{
    Schema::create('contenedores', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('numero_serie')->unique();
        $table->timestamps();
    });
}
```

En la migración de `usuario_contenedor`:

```php
public function up()
{
    Schema::create('usuario_contenedor', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_contenedor')->constrained('contenedores')->onDelete('cascade');
        $table->timestamps();
    });
}
```

En la migración de `division_contenedor`:

```php
public function up()
{
    Schema::create('division_contenedor', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_contenedor')->constrained('contenedores')->onDelete('cascade');
        $table->foreignId('id_tipo_basura')->constrained('tipobasura')->onDelete('cascade');
        $table->decimal('cantidad_kg', 10, 2)->default(0);
        $table->timestamps();
    });
}
```

Ejecuta las migraciones:

```bash
php artisan migrate
```

---

### **2. Crear Modelos**
Crea los modelos:

```bash
php artisan make:model Contenedor
php artisan make:model UsuarioContenedor
php artisan make:model DivisionContenedor
```

Define las relaciones en los modelos:

**Modelo `Contenedor.php`**
```php
class Contenedor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'numero_serie'];

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'usuario_contenedor', 'id_contenedor', 'id_usuario');
    }

    public function divisiones()
    {
        return $this->hasMany(DivisionContenedor::class, 'id_contenedor');
    }
}
```

**Modelo `DivisionContenedor.php`**
```php
class DivisionContenedor extends Model
{
    use HasFactory;

    protected $fillable = ['id_contenedor', 'id_tipo_basura', 'cantidad_kg'];

    public function contenedor()
    {
        return $this->belongsTo(Contenedor::class, 'id_contenedor');
    }

    public function tipoBasura()
    {
        return $this->belongsTo(TipoBasura::class, 'id_tipo_basura');
    }
}
```

---

### **3. Crear un Controlador**
Genera un controlador para manejar la lógica:

```bash
php artisan make:controller ContenedorController
```

Dentro de `ContenedorController.php`:

```php
public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'numero_serie' => 'required|string|unique:contenedores,numero_serie',
        'id_usuario' => 'required|exists:users,id'
    ]);

    // Registrar el contenedor
    $contenedor = Contenedor::create([
        'nombre' => $request->nombre,
        'numero_serie' => $request->numero_serie
    ]);

    // Asociar el contenedor al usuario
    UsuarioContenedor::create([
        'id_usuario' => $request->id_usuario,
        'id_contenedor' => $contenedor->id
    ]);

    // Obtener los tipos de basura
    $tiposBasura = TipoBasura::all();

    // Registrar automáticamente las divisiones
    foreach ($tiposBasura as $tipo) {
        DivisionContenedor::create([
            'id_contenedor' => $contenedor->id,
            'id_tipo_basura' => $tipo->id,
            'cantidad_kg' => 0
        ]);
    }

    return response()->json(['message' => 'Contenedor registrado correctamente'], 201);
}
```

---

### **4. Definir las Rutas**
En `routes/api.php` agrega la ruta para registrar el contenedor:

```php
Route::post('/contenedores', [ContenedorController::class, 'store']);
```

---

### **5. Probar con Postman**
Para probar el registro, usa un request `POST` en Postman con el siguiente JSON:

```json
{
    "nombre": "Contenedor Azul",
    "numero_serie": "CNTR123456",
    "id_usuario": 1
}
```

Esto creará el contenedor, lo enlazará con el usuario y generará las cuatro divisiones automáticamente.

---

### **Extras**
- Si necesitas que se actualice la cantidad de basura desde el Arduino, puedes hacer un `PUT` en `division_contenedor`.
- Para vaciar la basura y calcular tokens, puedes crear otro método en `VaciadoContenedorController`.

Con esto ya tienes el registro completo con Laravel 🚀
