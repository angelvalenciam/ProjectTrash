# Gerarquia de las migraciones 

```sql
Table usuarios {
  id integer [primary key]
  nombres varchar
  apellidos varchar
  ciudad varchar
  domicilio varchar 
  tokens integer  // Nuevo campo para almacenar los tokens del usuario
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
ahora yo angel compre un cupon para netflix como guardo el historial y las recompensas 


```


### Creacion logica 

> 1. tipoBasura ✅ 
> 2. contenedores ✅
> 3. usuarios ✅
> 4. recompensas ✅

#### Tablas pivote

> 1. usuario_contenedor ✅
> 2. historial recompensas ✅
> 3. vaciado_contenedor ✅  
> 4. historial_tokens✅
> 5. division_contenedor ✅

---

##### Creacion de los roles 

```php 
<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $role1 = Role::create(['name' => 'admin']);
        $role2  = Role::create(['name' => 'escritor']);
        $user = User::find(1);
        $user2 = User::find(2);
        if ($user) {
          $user->assignRole($role1);
          $user2->assignRole($role2); // Asegúrate de que el rol se asigna correctamente
      } else {
          throw new \Exception("Usuario con ID 1 no encontrado");
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Aquí puedes eliminar los roles si lo deseas
    }
};
```