# Solucion 

```sql
DELIMITER //

CREATE TRIGGER asignar_tokens
AFTER INSERT ON vaciado_contenedor
FOR EACH ROW
BEGIN
    DECLARE tokens_a_pagar INT;
    
    -- Calcula los tokens: 10 tokens por cada 1000 gramos (1 kg)
    SET tokens_a_pagar = FLOOR(NEW.cantidad_vaciada * 10);
    
    -- Actualiza los tokens del usuario
    UPDATE usuarios 
    SET tokens = tokens + tokens_a_pagar
    WHERE id = NEW.id_usuario;
END;
//

DELIMITER ;

```

---

# Explicacion 
Explicación
Se ejecuta automáticamente después de cada inserción en vaciado_contenedor.
Calcula los tokens en base a cantidad_vaciada * 10 (por cada 1 kg, da 10 tokens).
Se usa FLOOR() para evitar decimales.
Luego, suma los tokens al usuario correspondiente.


# Ejemplo de uso 

```sql 
INSERT INTO vaciado_contenedor (id_division_contenedor, id_usuario, fecha_vaciado, cantidad_vaciada)
VALUES (1, 1, NOW(), 4.5);
```
##### Trigger 

```sql 
SET tokens_a_pagar = FLOOR(4.5 * 10); -- tokens_a_pagar = 45
UPDATE usuarios SET tokens = tokens + 45 WHERE id = 1;
```

##### Alternativa sin trigger 

```php 
// Controlador de vaciado
public function registrarVaciado(Request $request)
{
    $vaciado = VaciadoContenedor::create([
        'id_division_contenedor' => $request->id_division_contenedor,
        'id_usuario' => $request->id_usuario,
        'fecha_vaciado' => now(),
        'cantidad_vaciada' => $request->cantidad_vaciada
    ]);

    // Calcular tokens
    $tokens_a_pagar = floor($request->cantidad_vaciada * 10);

    // Sumar tokens al usuario
    $usuario = Usuario::find($request->id_usuario);
    $usuario->tokens += $tokens_a_pagar;
    $usuario->save();

    return response()->json([
        'message' => 'Vaciado registrado y tokens asignados correctamente.',
        'tokens_asignados' => $tokens_a_pagar
    ]);
}
```
#### Trigger insertar token y guardar historial 
```sql 
DELIMITER //

CREATE TRIGGER asignar_tokens
AFTER INSERT ON vaciado_contenedor
FOR EACH ROW
BEGIN
    DECLARE tokens_a_pagar INT;
    
    -- Calcula los tokens (10 tokens por kg)
    SET tokens_a_pagar = FLOOR(NEW.cantidad_vaciada * 10);
    
    -- Actualiza los tokens del usuario
    UPDATE usuarios 
    SET tokens = tokens + tokens_a_pagar
    WHERE id = NEW.id_usuario;
    
    -- Registrar en historial de tokens
    INSERT INTO historial_tokens (id_usuario, id_vaciado, tokens_asignados, fecha_asignacion)
    VALUES (NEW.id_usuario, NEW.id, tokens_a_pagar, NOW());
END;
//

DELIMITER ;

```
---

``` sql 
INSERT INTO vaciado_contenedor (id_division_contenedor, id_usuario, fecha_vaciado, cantidad_vaciada)
VALUES (1, 1, NOW(), 3.5);

```

#### Trigger automatico 

``` sql 

UPDATE usuarios SET tokens = tokens + 35 WHERE id = 1; -- (3.5 kg * 10)
INSERT INTO historial_tokens (id_usuario, id_vaciado, tokens_asignados, fecha_asignacion)
VALUES (1, 1, 35, NOW());

```
#### Opcion a seleccionar 

✅ Si solo necesitas sumar tokens, la opción 1 es suficiente.
✅ Si quieres un historial detallado, usa la opción 2 con la tabla historial_tokens.