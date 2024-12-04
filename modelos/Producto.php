<?php
// Clase Categoria hereda de la clase Conectar
class Producto extends Conectar {

    // Obtiene todas las categorías activas
    public function obtener_producto() {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
        
        // Consulta SQL para obtener todas las categorías activas
        $consulta_sql = "SELECT * FROM producto";   

        // Prepara la consulta SQL
        $consulta = $conexion->prepare($consulta_sql);
        $consulta->execute();

        // Retorna el resultado de la consulta como un array asociativo
        return $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);   
    }

    // Obtiene una categoría específica por su ID
    public function obtener_producto_por_id($id) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
        
        // Consulta SQL para obtener una propietario     específica por su ID
        $consulta_sql = "SELECT * FROM producto WHERE idProducto = ?";

        // Prepara la consulta SQL
        $consulta = $conexion->prepare($consulta_sql);
        $consulta->bindValue(1, $id);  // Asocia el valor del ID de categoría

        // Ejecuta la consulta
        $consulta->execute();

        // Retorna el resultado como un array asociativo
        return $resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
    }

    // Inserta una nuevo propietario
    public function insertar_producto($nombre, $empresa) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
   
        // Sentencia SQL para insertar una nueva casa
        $sentencia_sql = "INSERT INTO `producto`(`idProducto`, `nombre`, `empresa`) VALUES (NULL,?,?)";
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $nombre);  
        $sentencia->bindValue(2, $empresa);  
        $sentencia->execute();
    
        return ["success" => true, "message" => "Inserción Realizada"];
    }

    // Actualiza una categoría existente
    public function actualizar_producto($nombre, $empresa, $id) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();

            // Si se proporcionó un DNI_propietario, lo actualizamos
            $sentencia_sql = "UPDATE `producto` SET `nombre`= ?, `empresa`= ? WHERE idProducto = ?";
            $sentencia = $conexion->prepare($sentencia_sql);
            $sentencia->bindValue(1, $nombre);
            $sentencia->bindValue(2, $empresa);
            $sentencia->bindValue(3, $id);

        
    
        // Ejecuta la sentencia
        $sentencia->execute();
    
        // Retorna el resultado (aunque no es necesario para un update, se puede omitir)
        return $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

    // Desactiva (elimina lógicamente) una categoría
    public function eliminar_usuario($id) {
        // Establece la conexión a la base de datos
        $conexion = parent::conectar_bd();
        parent::establecer_codificacion();
        
        // Sentencia SQL para "eliminar" (desactivar) una categoría
        $sentencia_sql = "DELETE FROM `producto` WHERE idProducto = ?";

        // Prepara la sentencia SQL
        $sentencia = $conexion->prepare($sentencia_sql);
        $sentencia->bindValue(1, $id);  // Asocia el ID de la categoría

        // Ejecuta la sentencia
        $sentencia->execute();

        // Retorna el resultado (aunque no es necesario para un delete lógico, se puede omitir)
        return $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
